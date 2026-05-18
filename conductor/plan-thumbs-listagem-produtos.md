# Plano: Exibição de Miniaturas na Listagem de Produtos

Este plano descreve as alterações necessárias para incluir uma coluna de imagem na listagem de produtos, permitindo a visualização da miniatura principal diretamente na tabela de gerenciamento.

## 1. Alterações no Model (`application/models/Produtos_model.php`)

### Objetivo
Ajustar o método `get` para recuperar a URL da miniatura marcada como principal.

### Mudanças:
- Alterar o `select` de `$fields` para `produtos.*, produtos_imagens.thumb`.
- Adicionar um `LEFT JOIN` com a tabela `produtos_imagens`:
  ```php
  $this->db->join('produtos_imagens', 'produtos_imagens.produtos_id = produtos.idProdutos AND produtos_imagens.principal = 1', 'left');
  ```
- Isolar a lógica de busca (`where`) com `group_start()` e `group_end()` para evitar conflitos com o JOIN e a ordenação.

## 2. Alterações na View (`application/views/produtos/produtos.php`)

### Objetivo
Inserir a coluna visual na tabela.

### Mudanças:
- Localizar a tabela de produtos.
- Adicionar um novo cabeçalho `<th>Foto</th>` após a coluna `<th>Cód.</th>`.
- No loop de resultados, adicionar o correspondente `<td>`:
  - Se `thumb` existir: Exibir a imagem em um tamanho reduzido (ex: 40px) com bordas arredondadas.
  - Se `thumb` não existir: Exibir um ícone de fallback (ex: `bx bx-image-alt`).

## 3. Verificação
1. Acessar o menu **Produtos**.
2. Verificar se a nova coluna aparece e exibe as fotos corretamente.
3. Realizar uma busca por descrição e código para garantir que o filtro continua funcionando.
4. Testar a paginação.
