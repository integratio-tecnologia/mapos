# Implementação da API do IBGE para Estados e Cidades

## Objetivo
Substituir o carregamento estático de estados e implementar a carga dinâmica de cidades através da API do IBGE na tela de adicionar clientes (`application/views/clientes/adicionarCliente.php`).

## Alterações Propostas

### 1. `application/views/clientes/adicionarCliente.php`
- Modificar o carregamento dos estados para utilizar a API do IBGE (`https://servicodados.ibge.gov.br/api/v1/localidades/estados`).
- Adicionar evento `change` no campo `select` de estado para buscar as cidades correspondentes via API do IBGE (`https://servicodados.ibge.gov.br/api/v1/localidades/estados/{UF}/municipios`).
- Adicionar/Atualizar um elemento `<select>` para o campo `cidade` para permitir a seleção.

## Passos de Implementação

1.  **Explorar o campo Cidade:** Verificar se o campo cidade atual precisa ser convertido para `select`.
2.  **Desenvolvimento do Script:**
    - Criar função para carregar estados na inicialização.
    - Criar função para carregar cidades baseada na seleção do estado.
3.  **Ajustes de UI:** Atualizar o campo `input` de cidade para `select`.
4.  **Verificação:** Testar o preenchimento automático na criação de clientes.

## Verificação e Testes
- Validar se a lista de estados é carregada corretamente ao abrir a página.
- Validar se a lista de cidades é carregada ao selecionar um estado.
- Garantir que o valor selecionado seja mantido em caso de erro de validação (se possível via PHP/JS).
