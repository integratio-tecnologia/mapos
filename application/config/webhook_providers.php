<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

$config['webhook_providers'] = [
     'GerencianetSdk' => [
        'name' => 'Efí Bank (antiga Gerencianet)',
        'requires_token' => false,
        'validation_rules' => [
            'type' => 'notification_token',
            'required_field' => 'notification'
        ],
        'payload_schema' => [
            'required_for_notification' => ['notification']
        ],
        'events' => [
            'new'        => 'Cobrança gerada, aguardando definição da forma de pagamento.',
            'waiting'    => 'Forma de pagamento selecionada, aguardando a confirmação do pagamento.',
            'paid'       => 'Pagamento confirmado.',
            'unpaid'     => 'Não foi possível confirmar o pagamento da cobrança.',
            'refunded'   => 'Pagamento devolvido pelo lojista ou pelo intermediador Efí.',
            'contested'  => 'Pagamento em processo de contestação.',
            'canceled'   => 'Cobrança cancelada pelo vendedor ou pelo pagador.',
            'settled'    => 'Cobrança foi confirmada manualmente.',
            'link'       => 'Link de pagamento foi criado.',
            'expired'    => 'Cobrança expirada por falta de pagamento até a data limite.',
            'updated'    => 'Alteração no vencimento ou valor de cobrança existente.'
        ],
    ],
    'MercadoPago' => [
        'name' => 'Mercado Pago',
        'requires_token' => true,
        'token_type' => 'header',
        'token_header' => 'x-signature',
        'validation_rules' => [
            'type' => 'standard_payload',
            'required_key' => 'required_for_payments'
        ],
        'payload_schema' => [
            'required_for_payments' => [
                'id',
                'live_mode', 
                'type',
                'date_created',
                'api_version',
                'action',
                'data'
            ]
        ],
        'events' => [
            'payment.created' => 'Criação e atualização de cobrança.',
            'payment.updated' => 'Atualização no status da cobrança',
        ],
    ],
    'Asaas' => [
        'name' => 'Asaas',
        'requires_token' => true,
        'token_type' => 'header',
        'token_header' => 'asaas-access-token',
        'validation_rules' => [
            'type' => 'standard_payload',
            'required_key' => 'required_for_payment'
        ],
        'payload_schema' => [
            'required_for_payment' => ['id', 'event', 'payment', 'dateCreated']
        ],
        'events' => [
            'PAYMENT_CREATED' => 'Nova cobrança gerada.',
            'PAYMENT_UPDATED' => 'Alteração no vencimento ou valor de cobrança existente.',
            'PAYMENT_CONFIRMED' => 'Cobrança confirmada (pagamento efetuado, porém, o saldo ainda não foi disponibilizado).',
            'PAYMENT_RECEIVED' => 'Cobrança recebida.',
            'PAYMENT_OVERDUE' => 'Cobrança vencida.',
            'PAYMENT_DELETED' => 'Cobrança removida.',
            'PAYMENT_RESTORED' => 'Cobrança restaurada.',
            'PAYMENT_REFUNDED' => 'Cobrança estornada.',
            'PAYMENT_REFUND_IN_PROGRESS' => 'Estorno em processamento.',
            'PAYMENT_RECEIVED_IN_CASH_UNDONE' => 'Recebimento em dinheiro desfeito.',
            'PAYMENT_CHARGEBACK_REQUESTED' => 'Recebido chargeback.',
            'PAYMENT_CHARGEBACK_DISPUTE' => 'Em disputa de chargeback.',
            'PAYMENT_AWAITING_CHARGEBACK_REVERSAL' => 'Disputa vencida, aguardando repasse.',
            'PAYMENT_DUNNING_RECEIVED' => 'Recebimento de negativação.',
            'PAYMENT_DUNNING_REQUESTED' => 'Requisição de negativação.',
            'PAYMENT_BANK_SLIP_VIEWED' => 'Boleto visualizado pelo cliente.',
            'PAYMENT_CHECKOUT_VIEWED' => 'Fatura visualizada pelo cliente.',
            'PAYMENT_APPROVED_BY_RISK_ANALYSIS' => 'Pagamento aprovado na análise de risco.',
            'PAYMENT_REPROVED_BY_RISK_ANALYSIS' => 'Pagamento reprovado na análise de risco.',
            'PAYMENT_AUTHORIZED' => 'Pagamento autorizado.',
            'PAYMENT_CREDIT_CARD_CAPTURE_REFUSED' => 'Captura do cartão recusada.',
            'PAYMENT_SPLIT_CANCELLED' => 'Split cancelado.',
            'PAYMENT_SPLIT_DIVERGENCE_BLOCK' => 'Split bloqueado por divergência.',
            'PAYMENT_SPLIT_DIVERGENCE_BLOCK_FINISHED' => 'Bloqueio de split finalizado.'
        ],
    ],
];

// Configurações administrativas
$config['webhook_admin'] = [
    'token' => 'seu-token-secreto-aqui',
    'rate_limit' => [
        'max_requests' => 100,
        'window' => 3600
    ],
    'timeout' => [
        'default' => 30,    // timeout padrão em segundos
        'long' => 60        // timeout para operações longas
    ]
];
