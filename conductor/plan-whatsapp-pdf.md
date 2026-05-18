# Plano de Implementação: Envio de PDF da OS via WhatsApp Cloud API

## Objetivo
Permitir que o Map-OS gere um PDF da Ordem de Serviço e envie automaticamente (ou manualmente via botão) para o WhatsApp do cliente, utilizando a abordagem mais segura de Media ID (Upload para os servidores da Meta).

## Arquivos Afetados
1.  `application/libraries/Whatsapp_cloud.php`
2.  `application/controllers/Os.php`
3.  `application/views/os/visualizarOs.php` (Possível adição de botão de envio manual)

## Etapas de Implementação

### 1. Atualizar a Biblioteca `Whatsapp_cloud.php`
Adicionar os métodos necessários para lidar com mídias:
*   `upload_media($file_path, $mime_type)`: Fará uma requisição `POST` para `/{phone-id}/media` com `multipart/form-data` para enviar o arquivo físico para a Meta e obter um `media_id`.
*   `send_document($to, $media_id, $filename, $caption)`: Fará uma requisição `POST` enviando uma mensagem do tipo `document`, vinculada ao `media_id` recebido no passo anterior.

### 2. Isolar a Lógica de Geração do PDF
Atualmente, o PDF da OS (seja A4 ou Térmica) costuma ser gerado e jogado direto no navegador (`output` em HTML ou MPDF direto para a tela).
*   Será necessário extrair (ou duplicar) a lógica que constrói o HTML da OS.
*   Utilizar o Mpdf (já presente no Map-OS) para renderizar esse HTML e salvar o resultado fisicamente no servidor em um diretório temporário (ex: `assets/arquivos/temp_os/os_123.pdf`).

### 3. Integrar Geração e Envio no Controller `Os.php`
Criar um novo método (ou adaptar o existente) para o disparo do WhatsApp que:
1.  Chame a função de gerar o PDF em disco.
2.  Invoque `$this->whatsapp_cloud->upload_media($path)`.
3.  Com o `$mediaId` em mãos, invoque `$this->whatsapp_cloud->send_document(...)`.
4.  Exclua o arquivo PDF temporário do disco (`unlink()`) para poupar espaço.

### 4. (Opcional/UX) Adicionar Botão de Envio Manual
Na view de visualização da OS (`visualizarOs.php`), ao lado de "Imprimir", adicionar um botão "Enviar PDF via WhatsApp" que faça uma requisição Ajax para disparar esse novo fluxo de envio de mídia.

## Considerações de Segurança e Custos
*   O arquivo PDF ficará no servidor local por menos de um segundo, sendo apagado logo após o envio, garantindo privacidade.
*   Conforme documentação da Meta, não há custo extra por upload de bytes. A tarifação ocorre estritamente pela "Janela de Conversa" de 24 horas aberta pelo disparo.

## Validação e Testes
*   Verificar se a pasta temporária possui permissão de gravação (`CHMOD`).
*   Confirmar se a biblioteca Mpdf consegue renderizar o arquivo silenciosamente no fundo.
*   Validar se o WhatsApp no destino recebe o PDF formatado corretamente e com o nome de arquivo adequado.
