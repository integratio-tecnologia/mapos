# Plano de Implementação: Enriquecimento de Endereços via CEP e ReceitaWS

Este plano descreve a criação de um script CLI para completar endereços de clientes automaticamente, utilizando APIs externas, respeitando a regra de "apenas preencher se vazio".

## 1. Alterações no Backend (`application/controllers/Tools.php`)

### Método `enriquecerEnderecos()`
- **Objetivo:** Identificar clientes com endereços incompletos e buscar dados faltantes.
- **Lógica de busca:**
    1.  Se `CEP` estiver preenchido: Buscar no **ViaCEP** e preencher rua, bairro, cidade, estado (se estiverem vazios).
    2.  Se `CEP` estiver vazio: Buscar CNPJ na tabela `clientes`, consultar **ReceitaWS**, e preencher CEP e endereço (se estiverem vazios).
    3.  Após cada atualização bem-sucedida de endereço, chamar `_getCoordinates()` para atualizar latitude/longitude.
- **Regra de Preenchimento:** O script apenas altera campos `null` ou `''`.

## 2. Fluxo da API
- **ViaCEP:** `https://viacep.com.br/ws/{cep}/json/`
- **ReceitaWS:** `https://receitaws.com.br/v1/cnpj/{cnpj}`

## 3. Verificação e Testes
- Rodar o comando `php index.php tools enriquecerEnderecos` no terminal.
- Validar se os clientes com endereços incompletos tiveram seus dados atualizados.
- Verificar se a geocodificação foi disparada corretamente após o enriquecimento.
