# Plano de Implementação: Monitor de Serviços

Este plano descreve a implementação de um novo módulo "Monitor de Serviços" no Map-OS, incluindo um mapa com marcadores de endereços de clientes e um painel Kanban para gestão de Ordens de Serviço (OS).

## Objetivos
- Criar um item de menu "Monitor de Serviços".
- Exibir um mapa (Leaflet) com a localização das OS ativas.
- Implementar um painel Kanban para visualizar e alterar o status das OS via arrastar e soltar (drag & drop).

## Alterações Propostas

### 1. Banco de Dados e Permissões
- Não serão necessárias alterações no esquema do banco de dados inicialmente (usaremos geocodificação em tempo de execução via Nominatim/OSM).
- Adicionar a permissão `vMonitor` nas views de gerenciamento de permissões.

### 2. Controller: `application/controllers/Monitor.php`
Criar um novo controller para gerenciar as funcionalidades do Monitor:
- `index()`: Renderiza a view principal do monitor.
- `getData()`: Retorna os dados das OS e Clientes em formato JSON para o Mapa e Kanban.
- `updateStatus()`: Endpoint para atualizar o status e a ordem de uma OS via AJAX.

### 3. Model: `application/models/Monitor_model.php`
Criar um model para realizar as consultas necessárias:
- `getOsAtivas()`: Busca OS que não estão em status final (Finalizado, Cancelado, Faturado) com dados do cliente.

### 4. View: `application/views/monitor/monitor.php`
Criar a interface do monitor:
- Interface com abas (Mapa / Kanban).
- Integração com Leaflet.js para o mapa.
- Kanban estruturado com colunas para cada status ativo.
- Uso de `jquery-ui` sortable para o drag & drop do Kanban.

### 5. Menu Lateral: `application/views/tema/menu.php`
- Adicionar o link para o Monitor de Serviços sob a condição de permissão `vMonitor`.

## Passos de Implementação

1. **Criar o Model `Monitor_model.php`**: Implementar a busca de OS ativas e join com clientes.
2. **Criar o Controller `Monitor.php`**: Implementar a lógica de entrega de dados e atualização de status.
3. **Atualizar Views de Permissões**: Adicionar o checkbox para `vMonitor` em `adicionarPermissao.php` e `editarPermissao.php`.
4. **Criar a View `monitor.php`**: Desenvolver a interface UI/UX com Mapa e Kanban.
5. **Atualizar o Menu Lateral**: Incluir o novo item "Monitor de Serviços".

## Verificação e Testes
- Verificar se o novo item de menu aparece apenas para usuários com permissão.
- Testar a exibição dos marcadores no mapa com endereços válidos.
- Testar o movimento de cards no Kanban e verificar se o status da OS é atualizado no banco de dados.
- Verificar a responsividade da nova view.
