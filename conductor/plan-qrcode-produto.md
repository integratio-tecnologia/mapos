# Plano: Adição de QRCode na Edição de Produtos

Este plano descreve as alterações necessárias para exibir um QRCode na tela de edição de produtos do Map-OS. O QRCode servirá como um link para o produto na loja, utilizando a URL base definida no arquivo `.env`.

## Objetivo
- Gerar um QRCode dinâmico na tela de edição de produtos.
- O QRCode deve apontar para: `{APP_BASEURL}/loja/produto/{idProdutos}`.
- Exibir o QRCode e o link correspondente de forma clara na interface de edição.

## Arquivos Afetados
- `application/controllers/Produtos.php`: Responsável por gerar o QRCode e passar os dados para a view.
- `application/views/produtos/editarProduto.php`: Responsável por exibir o QRCode na interface.

## Passos para Implementação

### 1. Alteração no Controlador (`application/controllers/Produtos.php`)
- No método `editar()`, após carregar os dados do produto em `$this->data['result']`, será adicionada a lógica de geração do QRCode.
- Utilizaremos a biblioteca `mpdf/qrcode` (já disponível no `composer.json`).
- A URL será construída usando `$_ENV['APP_BASEURL']` (conforme solicitado) com fallback para `base_url()`.

```php
// Lógica a ser adicionada:
$productId = $this->data['result']->idProdutos;
$baseUrl = rtrim($_ENV['APP_BASEURL'] ?? base_url(), '/');
$productUrl = $baseUrl . '/loja/produto/' . $productId;

$qrCode = new \Mpdf\QrCode\QrCode($productUrl);
$output = new \Mpdf\QrCode\Output\Svg();
$this->data['qrCode'] = $output->output($qrCode, 150);
$this->data['productUrl'] = $productUrl;
```

### 2. Alteração na View (`application/views/produtos/editarProduto.php`)
- Adicionar um novo bloco `control-group` após o campo "Estoque Mínimo".
- Exibir o SVG do QRCode gerado.
- Exibir o link textual abaixo do QRCode para facilitar a cópia ou clique direto.

```html
<div class="control-group">
    <label for="qrcode" class="control-label">Link da Loja (QRCode)</label>
    <div class="controls">
        <div style="display: flex; flex-direction: column; align-items: start;">
            <?php echo $qrCode; ?>
            <a href="<?php echo $productUrl; ?>" target="_blank" style="margin-top: 10px;"><?php echo $productUrl; ?></a>
        </div>
    </div>
</div>
```

## Verificação e Testes
1. Acessar a tela de edição de um produto existente.
2. Verificar se o QRCode é exibido corretamente após o campo de Estoque Mínimo.
3. Validar se o link textual corresponde à URL esperada.
4. Escanear o QRCode com um dispositivo móvel para garantir que redireciona para a URL correta.
5. Clicar no link para verificar se abre em uma nova aba.
