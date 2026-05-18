# Plano de Correção: Impressão de OS (A4)

Este plano visa corrigir problemas de quebra de página indevida, redimensionamento do QRCode PIX e exibição de anexos na view `imprimirOs.php`.

## 1. Problemas Identificados

1.  **Quebras de página indevidas:** O uso de `display: flex` na classe `.sub-page` e configurações de `pagebreak` do `html2pdf` estão causando saltos de página desnecessários entre as sessões da OS.
2.  **QRCode PIX reduzido no PDF:** O container flexível e a falta de dimensões fixas fazem com que o QRCode (muitas vezes um SVG) seja renderizado incorretamente ou em tamanho reduzido pelo `html2canvas`.
3.  **Imagens anexadas não exibidas:** 
    *   A lógica de exibição está condicionada à existência de `thumb`, o que pode excluir imagens válidas.
    *   A seção de anexos (`#anexos`) está com `display: none` no CSS base, e como o `html2pdf` renderiza em modo "screen", ela é ignorada na geração do PDF.

## 2. Alterações Propostas

### 2.1. Ajustes no CSS (`assets/css/imprimir.css`)

-   Alterar `.sub-page` de `display: flex` para `display: block` para melhorar a compatibilidade com o motor de renderização do PDF.
-   Tornar `.novaPagina` e `#anexos` visíveis por padrão (removendo `display: none`) para que sejam incluídos no PDF.
-   Definir dimensões fixas para o container do QRCode (`.qrcode-img`).
-   Ajustar as regras de `page-break` para serem mais assertivas.
-   Remover `min-height: 297mm` da `.main-page` para permitir que o conteúdo flua naturalmente, evitando páginas em branco forçadas.

### 2.2. Ajustes na View (`application/views/os/imprimirOs.php`)

-   **QRCode:** Adicionar atributos `width` e `height` explícitos à tag `<img>` do QRCode.
-   **Anexos:**
    *   Melhorar a lógica para exibir anexos que sejam imagens, independentemente de terem thumbnail.
    *   Garantir que os links dos anexos sejam absolutos e acessíveis.
-   **Configuração PDF:**
    *   Ajustar o objeto `opt` do `html2pdf` para usar `mode: 'css'` em `pagebreak` e remover o modo `legacy` que pode causar comportamentos imprevisíveis.
    *   Ajustar `html2canvas` para garantir que o QRCode e imagens sejam capturados corretamente.

## 3. Passos de Implementação

1.  **Modificar `assets/css/imprimir.css`:**
    *   Remover `display: none` de `.novaPagina` e `#anexos`.
    *   Mudar `.sub-page` para `display: block`.
    *   Ajustar `.qrcode-img` e `#anexos section img`.
2.  **Modificar `application/views/os/imprimirOs.php`:**
    *   Atualizar a tag `<img>` do QRCode com dimensões fixas.
    *   Refatorar o loop de anexos para identificar imagens por extensão.
    *   Atualizar o script de geração de PDF (`generatePDF`).

## 4. Verificação

-   Gerar PDF e verificar se a 2ª via e os anexos estão presentes.
-   Verificar se o QRCode está com tamanho legível (aprox. 130px).
-   Validar se as quebras de página ocorrem apenas quando necessário (fim da página real) e não entre pequenas sessões.
-   Verificar a impressão direta pelo navegador.
