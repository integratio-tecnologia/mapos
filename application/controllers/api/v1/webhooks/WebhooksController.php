<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class WebhooksController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        //Load config for payment gateway
        $this->load->config('payment_gateways');
    }

    public function index_post($provider)
    {
        $paymentProvider = reset(array_filter(
            $this->config->item('payment_gateways'),
            function ($gateway) use ($provider) {
                return strtolower($gateway['library_name']) === strtolower($provider);
            }
        ));

        $paymentProvider = $paymentProvider['library_name'] ?? null;
        
        // If no payment provider is found, return a 404 error
        if ($paymentProvider === null) {
            show_404();
        }
        
        // Load the payment gateway library
        $this->load->library("Gateways/$paymentProvider", null, 'PaymentGateway');
        
        // Process the webhook notification
        if (! $this->PaymentGateway->processarWebhooks()) {
            // If processing fails, return a 400 Bad Request
            $this->response([
                'status' => false,
                'message' => 'Erro ao processar o webhook',
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            // If processing is successful, return a 200 OK
            $this->response([
                'status' => true,
                'message' => 'Webhook processado com sucesso',
            ], REST_Controller::HTTP_OK);
        }
    }
}