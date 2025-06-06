<?php

use Libraries\Gateways\BasePaymentGateway;
use Libraries\Gateways\Contracts\PaymentGateway;
use MercadoPago\Payment;
use MercadoPago\SDK;

class MercadoPago extends BasePaymentGateway
{
    /** @var SDK */
    private $mercadoPagoApi;

    private $mercadoPagoConfig;

    private $signatureSecretKey;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->config('payment_gateways');
        $this->ci->load->model('Os_model');
        $this->ci->load->model('vendas_model');
        $this->ci->load->model('cobrancas_model');
        $this->ci->load->model('mapos_model');
        $this->ci->load->model('email_model');

        $mercadoPagoConfig = $this->ci->config->item('payment_gateways')['MercadoPago'];
        $this->mercadoPagoConfig = $mercadoPagoConfig;

        $mercadoPagoApi = new SDK();
        $mercadoPagoApi->setAccessToken($mercadoPagoConfig['credentials']['access_token']);
        $mercadoPagoApi->setPublicKey($mercadoPagoConfig['credentials']['public_key']);
        $mercadoPagoApi->setClientSecret($mercadoPagoConfig['credentials']['client_secret']);
        $mercadoPagoApi->setClientId($mercadoPagoConfig['credentials']['client_id']);
        $mercadoPagoApi->setIntegratorId($mercadoPagoConfig['credentials']['integrator_id']);
        $mercadoPagoApi->setPlatformId($mercadoPagoConfig['credentials']['platform_id']);
        $mercadoPagoApi->setCorporationId($mercadoPagoConfig['credentials']['corporation_id']);

        $this->mercadoPagoApi = $mercadoPagoApi;

        $this->signatureSecretKey = $mercadoPagoConfig['credentials']['signature_secret'] ?? null;
    }

    public function cancelar($id)
    {
        $cobranca = $this->ci->cobrancas_model->getById($id);
        if (! $cobranca) {
            throw new \Exception('Cobrança não existe!');
        }

        $payment = Payment::find_by_id($cobranca->charge_id);
        if ($payment->Error()) {
            throw new \Exception($payment->Error());
        }

        // Se o status for 'cancelled', não podemos cancelar novamente
        if ($payment->status !== 'cancelled') {
            $payment->status = 'cancelled';
            $payment->update();
            if ($payment->Error()) {
                throw new \Exception($payment->Error());
            }
        }

        return $this->atualizarDados($id);
    }

    public function enviarPorEmail($id)
    {
        $cobranca = $this->ci->cobrancas_model->getById($id);
        if (! $cobranca) {
            throw new \Exception('Cobrança não existe!');
        }

        $emitente = $this->ci->mapos_model->getEmitente();
        if (! $emitente) {
            throw new \Exception('Emitente não configurado!');
        }

        $html = $this->ci->load->view(
            'cobrancas/emails/cobranca',
            [
                'cobranca' => $cobranca,
                'emitente' => $emitente[0],
                'paymentGatewaysConfig' => $this->ci->config->item('payment_gateways'),
            ],
            true
        );

        $assunto = 'Cobrança - ' . $emitente[0]->nome;
        if ($cobranca->os_id) {
            $assunto .= ' - OS #' . $cobranca->os_id;
        } else {
            $assunto .= ' - Venda #' . $cobranca->vendas_id;
        }

        $remetentes = [$cobranca->email];
        foreach ($remetentes as $remetente) {
            $headers = [
                'From' => $emitente[0]->email,
                'Subject' => $assunto,
                'Return-Path' => '',
            ];
            $email = [
                'to' => $remetente,
                'message' => $html,
                'status' => 'pending',
                'date' => date('Y-m-d H:i:s'),
                'headers' => serialize($headers),
            ];
            $this->ci->email_model->add('email_queue', $email);
        }
    }

    public function atualizarDados($id)
    {
        $cobranca = $this->ci->cobrancas_model->getById($id);
        if (! $cobranca) {
            throw new \Exception('Cobrança não existe!');
        }

        $payment = Payment::find_by_id($cobranca->charge_id);
        if ($payment->Error()) {
            throw new \Exception($payment->Error());
        }

        if ($payment->status !== $cobranca->status) {
            // Cobrança foi paga ou foi confirmada de forma manual, então damos baixa
            if ($payment->status === 'approved') {
                // TODO: dar baixa no lançamento caso exista
            }
    
            $databaseResult = $this->ci->cobrancas_model->edit(
                'cobrancas',
                [
                    'status' => $payment->status,
                ],
                'idCobranca',
                $id
            );
    
            if ($databaseResult == true) {
                $this->ci->session->set_flashdata('success', 'Cobrança atualizada com sucesso!');
                log_info('Alterou um status de cobrança. ID' . $id);
            } else {
                $this->ci->session->set_flashdata('error', 'Erro ao atualizar cobrança!');
                throw new \Exception('Erro ao atualizar cobrança!');
            }
        }
    }

    public function confirmarPagamento($id)
    {
        $cobranca = $this->ci->cobrancas_model->getById($id);
        if (! $cobranca) {
            throw new \Exception('Cobrança não existe!');
        }

        $payment = Payment::find_by_id($cobranca->charge_id);
        if ($payment->Error()) {
            throw new \Exception($payment->Error());
        }

        $payment->capture();
        if ($payment->Error()) {
            throw new \Exception($payment->Error());
        }

        return $this->atualizarDados($id);
    }

    protected function gerarCobrancaBoleto($id, $tipo)
    {
        $entity = $this->findEntity($id, $tipo);
        $produtos = $tipo === PaymentGateway::PAYMENT_TYPE_OS
            ? $this->ci->Os_model->getProdutos($id)
            : $this->ci->vendas_model->getProdutos($id);
        $servicos = $tipo === PaymentGateway::PAYMENT_TYPE_OS
            ? $this->ci->Os_model->getServicos($id)
            : [];
        $desconto = [$tipo === PaymentGateway::PAYMENT_TYPE_OS
            ? $this->ci->Os_model->getById($id)
            : $this->ci->vendas_model->getById($id)];
        $tipo_desconto = [$tipo === PaymentGateway::PAYMENT_TYPE_OS
            ? $this->ci->Os_model->getById($id)
            : $this->ci->vendas_model->getById($id)];

        $totalProdutos = array_reduce(
            $produtos,
            function ($total, $item) {
                return $total + (floatval($item->preco) * intval($item->quantidade));
            },
            0
        );
        $totalServicos = array_reduce(
            $servicos,
            function ($total, $item) {
                return $total + (floatval($item->preco) * intval($item->quantidade));
            },
            0
        );
        $tipoDesconto = array_reduce(
            $tipo_desconto,
            function ($total, $item) {
                return $item->tipo_desconto;
            },
            0
        );
        $totalDesconto = array_reduce(
            $desconto,
            function ($total, $item) {
                return $item->desconto;
            },
            0
        );

        if (empty($entity)) {
            throw new \Exception('OS ou venda não existe!');
        }

        if (($totalProdutos + $totalServicos) <= 0) {
            throw new \Exception('OS ou venda com valor negativo ou zero!');
        }

        if ($err = $this->errosCadastro($entity)) {
            throw new \Exception($err);
        }

        $clientNameParts = explode(' ', $entity->nomeCliente);
        $documento = preg_replace('/[^0-9]/', '', $entity->documento);
        $expirationDate = (new DateTime())->add(new DateInterval($this->mercadoPagoConfig['boleto_expiration']));
        $expirationDate = ($expirationDate->format(DateTime::RFC3339_EXTENDED));

        $payment = new Payment();
        $payment->transaction_amount = floatval($this->valorTotal($totalProdutos, $totalServicos, $totalDesconto, $tipoDesconto));
        $payment->description = PaymentGateway::PAYMENT_TYPE_OS ? "OS #$id" : "Venda #$id";
        $payment->payment_method_id = 'bolbradesco';
        $payment->notification_url = base_url() . 'index.php/api/v1/webhooks/mercadopago';
        $payment->date_of_expiration = $expirationDate;
        $payment->payer = [
            'email' => $entity->email,
            'first_name' => $clientNameParts[0],
            'last_name' => $clientNameParts[count($clientNameParts) - 1],
            'identification' => [
                'type' => strlen($documento) == 11 ? 'CPF' : 'CNPJ',
                'number' => $documento,
            ],
            'address' => [
                'zip_code' => preg_replace('/[^0-9]/', '', $entity->cep),
                'street_name' => $entity->rua,
                'street_number' => $entity->numero,
                'neighborhood' => $entity->bairro,
                'city' => $entity->cidade,
                'federal_unit' => $entity->estado,
            ],
        ];

        $payment->save();
        if ($payment->Error()) {
            throw new \Exception($payment->Error());
        }

        $data = [
            'barcode' => $payment->barcode->content,
            'link' => $payment->transaction_details->external_resource_url,
            'pdf' => $payment->transaction_details->external_resource_url,
            'expire_at' => $payment->date_of_expiration,
            'charge_id' => $payment->id,
            'status' => $payment->status,
            'total' => getMoneyAsCents($this->valorTotal($totalProdutos, $totalServicos, $totalDesconto, $tipoDesconto)),
            'clientes_id' => $entity->idClientes,
            'payment_method' => 'boleto',
            'payment_gateway' => 'MercadoPago',
        ];

        if ($tipo === PaymentGateway::PAYMENT_TYPE_OS) {
            $data['os_id'] = $id;
        } else {
            $data['vendas_id'] = $id;
        }

        if ($id = $this->ci->cobrancas_model->add('cobrancas', $data, true)) {
            $data['idCobranca'] = $id;
            log_info('Cobrança criada com successo. ID: ' . $payment->id);
        } else {
            throw new \Exception('Erro ao salvar cobrança!');
        }

        return $data;
    }

    protected function gerarCobrancaLink($id, $tipo)
    {
        throw new Exception('MercadoPago não suporta gerar link pela API, somente pelo painel!');
    }

    private function valorTotal($produtosValor, $servicosValor, $desconto, $tipo_desconto)
    {
        if ($tipo_desconto == 'porcento') {
            $def_desconto = $desconto * ($produtosValor + $servicosValor) / 100;
        } elseif ($tipo_desconto == 'real') {
            $def_desconto = $desconto;
        } else {
            $def_desconto = 0;
        }

        return ($produtosValor + $servicosValor) - $def_desconto;
    }

    /**
     * Processa notificações de pagamento do Mercado Pago.
     */

    protected function processarWebhook() : bool
    {
        $request_body = file_get_contents('php://input');
        $notification = json_decode($request_body, true);

        $x_signature_header = isset($_SERVER['HTTP_X_SIGNATURE']) ? $_SERVER['HTTP_X_SIGNATURE'] : null;
        $x_request_id_header = isset($_SERVER['HTTP_X_REQUEST_ID']) ? $_SERVER['HTTP_X_REQUEST_ID'] : null;

        if (!$x_signature_header) {
            log_info('Erro: Header X-Signature ausente.', 'MercadoPago Webhooks');
            return false;
        }

        if (!$notification || !isset($notification['data']['id']) || !isset($notification['type']) || !isset($notification['action'])) {
            log_info('Erro: Notificação inválida.', 'MercadoPago Webhooks');
            return false;
        }

        if (!$this->validarAssinaturaNotificacao($x_signature_header, $request_body, $notification['data']['id'], $x_request_id_header)) {
            log_info('Erro: Assinatura inválida.', 'MercadoPago Webhooks');
            return false;
        }

        if (! $this->handleWebhookEvent($notification)) {
            return false;
        };

        return true;
    }

    /**
     * Valida a assinatura do webhook.
     */

    private function validarAssinaturaNotificacao($signature, $payload, $id, $x_request_id = null) : bool
    {
        if (!$this->signatureSecretKey) {
            log_info('Erro: Chave secreta de assinatura não configurada.', 'MercadoPago Webhooks');
            return false;
        }

        $parts = explode(',', $signature);
        $ts = null;
        $hash_from_mp = null;

        foreach ($parts as $part) {
            list($key, $value) = explode('=', trim($part), 2);
            if ($key === 'ts') {
                $ts = $value;
            } elseif ($key === 'v1') {
                $hash_from_mp = $value;
            }
        }

        if ($ts === null || $hash_from_mp === null) {
            log_info('Erro: ts ou hash não encontrado no header X-Signature: ' . $signature, 'MercadoPago Webhooks');
            return false;
        }

        $manifest = "id:{$id};request-id:{$x_request_id};ts:{$ts};";
        $calculated_hash = hash_hmac('sha256', $manifest, $this->signatureSecretKey);

        if (!hash_equals($calculated_hash, $hash_from_mp)) {
            log_info("Erro: SIGNATURE_SECRET inválido.", 'MercadoPago Webhooks');
            return false;
        }
        return true;
    }

    /**
     * Manipula o evento do webhook.
     */

    private function handleWebhookEvent($notification) : bool
    {   
        if ($notification['type'] === 'payment' && $notification['action'] === 'payment.updated') {

            $cobranca = $this->ci->cobrancas_model->getById($notification['data']['id']);
            if (! $cobranca) {
                log_info("Erro: Cobrança não encontrada no banco de dados. ID: {$notification['data']['id']}", 'MercadoPago Webhooks');
                return false;
            }

            // Atualiza dados da cobrança com o status do pagamento.
            $this->atualizarDados($cobranca->idCobranca);

            log_info("Notificação de pagamento recebida e processada com sucesso. ID Recurso: {$notification['data']['id']}, Tipo: {$notification['type']}, Ação: {$notification['action']}", 'MercadoPago Webhooks');
            return true;
        } else {
            log_info("Atenção: Evento não suportado ou não implementado. Tipo: {$notification['type']}, Ação: {$notification['action']}", 'MercadoPago Webhooks');
            return false;
        }
    }
}
