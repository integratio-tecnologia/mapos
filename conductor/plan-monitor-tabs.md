# Plano de Implementação: Novas Abas no Monitor de Serviços

Este plano descreve a adição das abas **Resumo** e **Clima** ao Monitor de Serviços, integrando estatísticas de OS e dados meteorológicos em tempo real.

## 1. Alterações no Backend

### Controller `Monitor.php`
- Carregar o modelo `mapos_model` no método `index` para obter os dados do emitente (cidade/estado).
- Implementar o método `getStats()` para retornar contagens de OS por status (Aberto, Em Andamento, Aguardando Peças, etc).

### Model `Monitor_model.php`
- Adicionar o método `getStats()` que realiza um `GROUP BY status` na tabela `os`.

## 2. Alterações no Frontend

### View `monitor/monitor.php`
- **Navegação:** Adicionar links para as abas `#tab-resumo`, `#tab-kanban`, `#tab-mapa` e `#tab-clima`.
- **Aba Resumo:** Exibir cards com contadores de OS e um gráfico simples (opcional, dependendo das bibliotecas disponíveis).
- **Aba Clima:**
    - Integrar a API do OpenWeatherMap.
    - Exibir um mapa Leaflet centralizado na cidade do emitente.
    - Adicionar camadas climáticas ao mapa (Nuvens, Chuva).
    - Exibir um widget com a temperatura atual, umidade e descrição do clima.

## 3. Integração com API de Clima
- Utilizar a API pública do OpenWeatherMap.
- Obter as coordenadas da cidade do emitente via geocodificação (usando a mesma lógica já implementada no sistema).

## 4. Verificação e Testes
- Validar se os contadores da aba Resumo batem com o banco de dados.
- Verificar se o mapa de clima carrega corretamente centralizado na cidade configurada.
- Testar a troca de abas e o redimensionamento do mapa (`invalidateSize`).
