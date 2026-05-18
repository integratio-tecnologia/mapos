# Plano de Implementação: Melhorias na Visualização de Cliente

Este plano descreve as alterações na tela de visualização de cliente para incluir a listagem de contatos no accordion e a exibição de um mapa do endereço.

## Objetivos
- Listar todos os contatos associados ao cliente dentro do accordion "Contatos".
- Exibir um mapa (Leaflet) com a localização do cliente dentro do accordion "Endereço".

## Alterações Propostas

### 1. View: `application/views/clientes/visualizar.php`
- **Accordion Contatos:** Inserir uma tabela com a lista da variável `$contatos` (já disponível no controller).
- **Accordion Endereço:** 
    - Inserir um `div#map` abaixo da tabela de endereço.
    - Incluir assets do Leaflet (CSS e JS) via CDN.
    - Adicionar script para inicializar o mapa usando as coordenadas `latitude` e `longitude` do cliente.
    - Implementar fallback de geocodificação caso as coordenadas não estejam preenchidas.

## Passos de Implementação

1. **Atualizar Accordion Contatos:** Modificar a seção `collapseGTwo` para incluir a listagem de contatos adicionais.
2. **Adicionar Mapa no Accordion Endereço:** Modificar a seção `collapseGThree` para incluir o container do mapa.
3. **Incluir Scripts e Estilos:** Adicionar Leaflet e a lógica de inicialização do mapa no final do arquivo.

## Verificação e Testes
- Abrir a visualização de um cliente com contatos e verificar se aparecem no accordion.
- Verificar se o mapa é exibido corretamente no accordion de endereço.
- Testar o funcionamento do mapa para clientes com e sem coordenadas salvas no banco.
