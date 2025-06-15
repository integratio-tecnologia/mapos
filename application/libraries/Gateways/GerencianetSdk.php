<?php

use Efi\EfiPay;
use Libraries\Gateways\BasePaymentGateway;
use Libraries\Gateways\Contracts\PaymentGateway;

class GerencianetSdk extends BasePaymentGateway
{
    /** @var Gerencianet */
    private $gerenciaNetApi;

    private $gerenciaNetConfig;

    private $webhookEvents;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->config('payment_gateways');
        $this->ci->load->model('Os_model');
        $this->ci->load->model('vendas_model');
        $this->ci->load->model('cobrancas_model');
        $this->ci->load->model('mapos_model');
        $this->ci->load->model('email_model');
        
        $gerenciaNetConfig = $this->ci->config->item('payment_gateways')['GerencianetSdk'];
        $webhookEvents = $this->ci->config->item('webhook_providers')['GerencianetSdk']['events'];
        $webhookEvents = array_keys($webhookEvents);
        $this->gerenciaNetConfig = $gerenciaNetConfig;
        $this->gerenciaNetApi = new EfiPay([
            'client_id' => $gerenciaNetConfig['credentials']['client_id'],
            'client_secret' => $gerenciaNetConfig['credentials']['client_secret'],
            'sandbox' => $gerenciaNetConfig['production'] !== true,
            'timeout' => $gerenciaNetConfig['timeout'],
        ]);
    }

    public function cancelar($id)
    {
        $cobranca = $this->ci->cobrancas_model->getById($id);
        if (! $cobranca) {
            throw new \Exception('Cobrança não existe!');
        }

        $response = $this->gerenciaNetApi->cancelCharge(['id' => $cobranca->charge_id], []);
        if (intval($response['code']) !== 200) {
            throw new \Exception('Erro ao chamar GerenciaNet!');
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
                'emitente' => $emitente,
                'paymentGatewaysConfig' => $this->ci->config->item('payment_gateways'),
            ],
            true
        );

        $assunto = 'Cobrança - ' . $emitente->nome;
        if ($cobranca->os_id) {
            $assunto .= ' - OS #' . $cobranca->os_id;
        } else {
            $assunto .= ' - Venda #' . $cobranca->vendas_id;
        }

        $remetentes = [$cobranca->email];
        foreach ($remetentes as $remetente) {
            $headers = [
                'From' => $emitente->email,
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

        $result = $this->gerenciaNetApi->detailCharge(['id' => $cobranca->charge_id], []);
        if (intval($result['code']) !== 200) {
            throw new \Exception('Erro ao chamar GerenciaNet!');
        }

        // Cobrança foi paga ou foi confirmada de forma manual, então damos baixa
        if ($result['data']['status'] == 'paid' || $result['data']['status'] == 'settled') {
            // TODO: dar baixa no lançamento caso exista
        }

        $databaseResult = $this->ci->cobrancas_model->edit(
            'cobrancas',
            [
                'status' => $result['data']['status'],
            ],
            'idCobranca',
            $cobranca->idCobranca
        );

        if ($databaseResult == true) {
            $this->ci->session->set_flashdata('success', 'Cobrança atualizada com sucesso!');
            log_info('Alterou um status de cobrança. ID' . $id);
        } else {
            $this->ci->session->set_flashdata('error', 'Erro ao atualizar cobrança!');
            throw new \Exception('Erro ao atualizar cobrança!');
        }
    }

    public function confirmarPagamento($id)
    {
        $cobranca = $this->ci->cobrancas_model->getById($id);
        if (! $cobranca) {
            throw new \Exception('Cobrança não existe!');
        }

        $response = $this->gerenciaNetApi->settleCharge(['id' => $cobranca->charge_id], []);
        if (intval($response['code']) !== 200) {
            throw new \Exception('Erro ao chamar GerenciaNet!');
        }

        return $this->atualizarDados($id);
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
        $totalDesconto = array_reduce(
            $desconto,
            function ($total, $item) {
                return $item->desconto;
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

        if (empty($entity)) {
            throw new \Exception('OS ou venda não existe!');
        }

        if (($totalProdutos + $totalServicos) <= 0) {
            throw new \Exception('OS ou venda com valor negativo ou zero!');
        }

        if ($err = $this->errosCadastro($entity)) {
            throw new \Exception($err);
        }

        $address = [
            'street' => $entity->rua,
            'number' => $entity->numero,
            'neighborhood' => $entity->bairro,
            'zipcode' => preg_replace('/[^0-9]/', '', $entity->cep),
            'city' => $entity->cidade,
            'complement' => $entity->complemento,
            'state' => $entity->estado,
        ];

        $documento = preg_replace('/[^0-9]/', '', $entity->documento);
        $telefone = preg_replace('/[^0-9]/', '', $entity->telefone);
        if (strlen($documento) == 11) {
            $customer = [
                'name' => $entity->nomeCliente,
                'cpf' => $documento,
                'phone_number' => $telefone,
                'email' => $entity->email,
                'address' => $address,
            ];
        } else {
            $customer = [
                'juridical_person' => [
                    'corporate_name' => $entity->nomeCliente,
                    'cnpj' => $documento,
                ],
                'phone_number' => $telefone,
                'email' => $entity->email,
                'address' => $address,
            ];
        }
        $expirationDate = (new DateTime())->add(new DateInterval($this->gerenciaNetConfig['boleto_expiration']));
        $expirationDate = ($expirationDate->format('Y-m-d'));
        $body = [
            'items' => [
                [
                    'name' => $tipo === PaymentGateway::PAYMENT_TYPE_OS ? "OS #$id" : "Venda #$id",
                    'amount' => 1,
                    'value' => getMoneyAsCents($this->valorTotal($totalProdutos, $totalServicos, $totalDesconto, $tipoDesconto)),
                ],
            ],
            'metadata' => [
                'notification_url' => base_url() . 'index.php/api/v1/webhooks/client/gerencianetsdk',
            ],
            'payment' => [
                'banking_billet' => [
                    'expire_at' => $expirationDate,
                    'message' => 'Pago em qualquer loterica\nPagar até o vencimento\nCaixa após vencimento não aceitar',
                    'customer' => $customer,
                ],
            ],
        ];

        $result = $this->gerenciaNetApi->createOneStepCharge([], $body);
        if (intval($result['code']) !== 200) {
            throw new \Exception('Erro ao chamar GerenciaNet!');
        }

        $data = [
            'barcode' => $result['data']['barcode'],
            'link' => $result['data']['link'],
            'pdf' => $result['data']['pdf']['charge'],
            'expire_at' => $result['data']['expire_at'],
            'charge_id' => $result['data']['charge_id'],
            'status' => $result['data']['status'],
            'total' => getMoneyAsCents($this->valorTotal($totalProdutos, $totalServicos, $totalDesconto, $tipoDesconto)),
            'payment' => $result['data']['payment'],
            'clientes_id' => $entity->idClientes,
            'payment_method' => 'boleto',
            'payment_gateway' => 'GerencianetSdk',
        ];

        if ($tipo === PaymentGateway::PAYMENT_TYPE_OS) {
            $data['os_id'] = $id;
        } else {
            $data['vendas_id'] = $id;
        }

        if ($id = $this->ci->cobrancas_model->add('cobrancas', $data, true)) {
            $data['idCobranca'] = $id;
            log_info('Cobrança criada com successo. ID: ' . $result['data']['charge_id']);
        } else {
            throw new \Exception('Erro ao salvar cobrança!');
        }

        return $data;
    }

    protected function gerarCobrancaLink($id, $tipo)
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
                return $total + (floatval($item->desconto));
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

        $expirationDate = (new DateTime())->add(new DateInterval('P3D'));
        $expirationDate = ($expirationDate->format('Y-m-d'));
        $title = $tipo === PaymentGateway::PAYMENT_TYPE_OS ? "OS #$id" : "Venda #$id";

        $items = [
            [
                'name' => $tipo === PaymentGateway::PAYMENT_TYPE_OS ? "OS #$id" : "Venda #$id",
                'amount' => 1,
                'value' => getMoneyAsCents($this->valorTotal($totalProdutos, $totalServicos, $totalDesconto, $tipoDesconto)),
            ],
        ];

        $metadata = [
            "notification_url" => base_url() . "index.php/webhooks/client/gerencianetsdk"
        ];

        $settings = [
            "payment_method" => "all",
            "expire_at" => $expirationDate,
            "request_delivery_address" => false,
            'message' => 'Pagamento referente a ' . $title,
        ];

        $body = [
            "items" => $items,
            "metadata" => $metadata,
            "settings" => $settings,
        ];

        $result = $this->gerenciaNetApi->createOneStepLink($params = [], $body);

        if (intval($result['code']) !== 200) {
            throw new \Exception('Erro ao chamar GerenciaNet!');
        }

        $data = [
            'expire_at' => $result['data']['expire_at'],
            'charge_id' => $result['data']['charge_id'],
            'status' => $result['data']['status'],
            'total' => getMoneyAsCents($this->valorTotal($totalProdutos, $totalServicos, $totalDesconto, $tipoDesconto)),
            'clientes_id' => $entity->idClientes,
            'payment_method' => 'link',
            'payment_gateway' => 'GerencianetSdk',
            'payment_url' => $result['data']['payment_url'],
            'link' => $result['data']['payment_url'],
            'message' => $result['data']['message'],
        ];

        if ($tipo === PaymentGateway::PAYMENT_TYPE_OS) {
            $data['os_id'] = $id;
        } else {
            $data['vendas_id'] = $id;
        }

        if ($id = $this->ci->cobrancas_model->add('cobrancas', $data, true)) {
            $data['idCobranca'] = $id;
            log_info('Cobrança criada com successo. ID: ' . $result['data']['charge_id']);
        } else {
            throw new \Exception('Erro ao salvar cobrança!');
        }

        return $data;
    }

    protected function validarToken(): void
    {
        $notification = $this->ci->input->post('notification');

        if (!$notification) {
            LogContext::set('error_type', 'missing_notification');
            throw new \Exception('Token de notificação não encontrado', WebhooksController::ERROR_MISSING_TOKEN);
        }

        LogContext::set('notification_token', $notification);
        LogContext::set('token_validated', true);
    }

    protected function validarPayload(): void
    {
        // Efípay não requer validação de payload pois envia apenas o token
        // A validação real acontece ao consultar a API com o token
        return;
    }

    public function processarNotificacao(): void
    {
        $notification = LogContext::get('notification_token');
        
        $params = [
            'token' => $notification,
        ];

        LogContext::set('notification_received', true);

        try {
            $chargeNotification = $this->gerenciaNetApi->getNotification($params, []);

            $i = count($chargeNotification["data"]);

            $ultimoStatus = $chargeNotification["data"][$i-1];
            
            $status = $ultimoStatus["status"];
            
            $charge_id = $ultimoStatus["identifiers"]["charge_id"];
            
            $statusAtual = $status["current"];

            if (! in_array($status, $this->webhookEvents)) {
                log_info("Erro: Evento não suportado. ID Cobrança: {$charge_id}, Evento: {$status}", 'Efipay (Gerencianet)');
                throw new \Exception('Evento não suportado', WebhooksController::ERROR_UNSUPPORTED_EVENT);
            }
            
            $this->atualizarDados($charge_id);
            
            LogContext::set('notification_processed', true);
            log_info("Notificação processada com sucesso. ID Pagamento: {$charge_id}", 'Efípay Webhook');
        } catch (Exception $e) {
            LogContext::set('error_type', 'api_error');
            LogContext::set('api_error', $e->getMessage());
            throw new \Exception('Erro ao consultar notificação: ' . $e->getMessage(), WebhooksController::ERROR_PROVIDER_CONFIG_NOT_FOUND);
        }
    }
}
