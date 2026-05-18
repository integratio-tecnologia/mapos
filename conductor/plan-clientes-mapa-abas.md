# Plano de Implementação: Mapa e Abas na Listagem de Clientes

Este plano descreve a reestruturação da tela de listagem de clientes para suportar abas, visualização geográfica e filtros por cidade.

## 1. Alterações no Backend (Controller `Clientes.php`)

### Método `gerenciar()`
- Alterar para buscar a lista de cidades únicas (`DISTINCT cidade`) presentes na tabela `clientes`.
- Implementar suporte ao parâmetro de busca `cidade` via GET para filtrar a listagem paginada.

### Novo Método `getGeographicData()`
- Criar método que responda via AJAX.
- Retornar um JSON contendo todos os clientes que possuem coordenadas válidas (latitude/longitude), permitindo o filtro por cidade opcional.

## 2. Alterações no Frontend (View `clientes/clientes.php`)

### Estrutura de Abas (Bootstrap 2)
- Criar navegação por abas: **"Listagem de Clientes"** e **"Mapa de Clientes"**.
- Mover a tabela atual para a primeira aba.

### Filtros e Busca
- Adicionar um seletor (`<select>`) ao lado da busca textual com a lista de cidades obtida do backend.
- O filtro deve ser global (afetar tanto a lista quanto o mapa).

### Mapa de Clientes
- Integrar Leaflet na segunda aba.
- Implementar lógica para carregar marcadores de todos os clientes filtrados.
- Agrupar marcadores em locais com as mesmas coordenadas.
- Garantir `invalidateSize()` ao alternar para a aba do mapa.

## 3. Verificação e Testes
- Validar se a paginação da lista continua funcionando com o filtro de cidade.
- Verificar se o mapa carrega todos os marcadores corretamente.
- Testar o comportamento ao filtrar uma cidade que possui muitos clientes.
