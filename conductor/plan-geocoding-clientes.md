# Plano de Implementação: Script de Geocodificação de Clientes

Este plano descreve a criação de um comando CLI no MapOS para buscar latitude e longitude dos clientes com base em seus endereços e atualizar o banco de dados.

## Objetivo
Automatizar a atualização das coordenadas geográficas (latitude e longitude) dos clientes na tabela `clientes`, utilizando a API do Nominatim (OpenStreetMap).

## Arquivos e Contexto
- **Controller**: `application/controllers/tools/Geocoding.php` (Novo ou adicionar ao `Tools.php`)
- **Model**: `application/models/Clientes_model.php` (Existente)
- **Campos de Endereço**: `rua`, `numero`, `bairro`, `cidade`, `estado`, `cep`.
- **Campos de Destino**: `latitude`, `longitude`.

## Passos de Implementação

1. **Criar o Controller de Geocodificação**:
   - Criar `application/controllers/tools/Geocoding.php`.
   - Garantir que o comando só possa ser executado via CLI por segurança.
   - Implementar a lógica de:
     - Buscar todos os clientes que possuem endereço mas não possuem latitude/longitude.
     - Montar a string de busca para a API.
     - Realizar a requisição para a API do Nominatim.
     - Respeitar o limite de taxa da API (1 requisição por segundo).
     - Atualizar os campos `latitude` e `longitude` no banco de dados.

2. **Lógica de Geocodificação**:
   - Concatenar campos: `{$rua}, {$numero}, {$bairro}, {$cidade}, {$estado}, {$cep}, Brasil`.
   - Utilizar `curl` ou `file_get_contents` para chamar a API: `https://nominatim.openstreetmap.org/search?format=json&q=...`
   - Definir um `User-Agent` obrigatório conforme políticas da API.

3. **Verificação e Testes**:
   - Testar o comando com um cliente específico.
   - Verificar a atualização no banco de dados.
   - Executar para todos os clientes pendentes.

## Exemplo de Comando
```bash
php index.php tools/geocoding atualizar
```

## Considerações
- **API Nominatim**: É gratuita mas possui limites de uso (1 requisição por segundo). O script incluirá um `sleep(1)` entre cada cliente.
- **Precisão**: A precisão depende da qualidade dos endereços cadastrados.
- **Backup**: Recomenda-se fazer um backup da tabela `clientes` antes de executar o script.
