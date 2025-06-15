<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class WebhooksController extends REST_Controller
{
    //Constantes de erro
    const ERROR_PROVIDER_NOT_FOUND = 1001;
    const ERROR_PROVIDER_NOT_SPECIFIED = 1002;
    const ERROR_PROVIDER_CONFIG_NOT_FOUND = 1003;
    const ERROR_MISSING_TOKEN = 1004;
    const ERROR_INVALID_SIGNATURE = 1005;
    const ERROR_UNSUPPORTED_EVENT = 1006;
    const ERROR_INVALID_PAYLOAD = 1007;
    const ERROR_MISSING_REQUIRED_FIELD = 1008;
    const ERROR_RATE_LIMIT_EXCEEDED = 1009;
    const ERROR_REQUEST_TIMEOUT = 1010;
    
    protected $providers;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('LogContext');
        $this->load->library('RateLimiter');
        $this->load->driver('cache', ['adapter' => 'file']); // ou outro adapter de sua preferência

        $this->rateLimiter = new RateLimiter();

        $this->loadProviders();
    }

    private function executeWithTimeout(callable $callback, int $timeout = null): mixed
    {
        if (!$timeout) {
            $this->config->load('webhook_providers');
            $timeout = $this->config->item('webhook_admin')['timeout']['default'] ?? 30;
        }

        set_time_limit($timeout);
        
        try {
            return $callback();
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'Maximum execution time') !== false) {
                throw new \Exception('Tempo limite excedido', self::ERROR_REQUEST_TIMEOUT);
            }
            throw $e;
        }
    }

    public function index_post($provider = null)
    {
        try {
            log_message('debug', '[Debug] Iniciando index_post');

            $ip = $this->input->ip_address();
            if (!$this->rateLimiter->check($ip)) {
                $resetTime = $this->rateLimiter->getResetTime($ip);
                $this->output->set_header('Retry-After: ' . $resetTime);
                throw new \Exception('Limite de requisições excedido', self::ERROR_RATE_LIMIT_EXCEEDED);
            }

            $remaining = $this->rateLimiter->getRemainingAttempts($ip);
            $this->output->set_header('X-RateLimit-Remaining: ' . $remaining);
            $this->output->set_header('X-RateLimit-Reset: ' . $this->rateLimiter->getResetTime($ip));

            LogContext::clear();
            LogContext::set('provider', $provider);
            LogContext::set('request_id', uniqid('webhook_'));
            
            $provider = $this->validateAndNormalizeProvider($provider);
            LogContext::set('normalized_provider', $provider);
            
            $this->load->library("Gateways/$provider", null, 'WebhookGateway');
            
            $this->executeWithTimeout(function() use ($provider) {
                $this->WebhookGateway->validarNotificacao();
                $this->WebhookGateway->processarNotificacao();
            });
            
            $this->response([
                'status' => 'success',
                'request_id' => LogContext::get('request_id')
            ], REST_Controller::HTTP_OK);
            
        } catch (\Exception $e) {
            $this->logError($e);
            $this->handleError($e);
        }
    }

    private function loadProviders()
    {
        $providers = $this->cache->get('webhook_providers');
        
        if (!$providers) {
            $this->config->load('webhook_providers');
            $providers = $this->config->item('webhook_providers');
            
            if (!$providers) {
                throw new \Exception('Configuração de provedores não encontrada', self::ERROR_PROVIDER_CONFIG_NOT_FOUND);
            }

            $this->cache->save('webhook_providers', $providers, 3600);
        }

        $this->providers = array_keys($providers);
        LogContext::set('available_providers', $this->providers);
    }

    private function validateAndNormalizeProvider($provider)
    {
        if (!$provider) {
            throw new \Exception('Provider não especificado');
        }

        $normalizedProvider = array_filter(
            $this->providers,
            function($key) use ($provider) {
                return strtolower($key) === strtolower($provider);
            }
        );

        if (empty($normalizedProvider)) {
            throw new \Exception('Provider inválido');
        }

        return reset($normalizedProvider);
    }

    private function handleError(\Exception $e)
    {
        $errorCode = $e->getCode() ?: self::ERROR_PROVIDER_NOT_FOUND;
        $httpCode = $this->getHttpCodeFromError($errorCode);
        
        $this->response([
            'status' => 'error',
            'error_code' => $errorCode,
            'message' => $e->getMessage(),
            'request_id' => LogContext::get('request_id')
        ], $httpCode);
    }

    private function getHttpCodeFromError($errorCode)
    {
        $errorMap = [
            self::ERROR_PROVIDER_NOT_SPECIFIED => self::HTTP_BAD_REQUEST,
            self::ERROR_PROVIDER_NOT_FOUND => self::HTTP_NOT_FOUND,
            self::ERROR_PROVIDER_CONFIG_NOT_FOUND => self::HTTP_INTERNAL_SERVER_ERROR,
            self::ERROR_MISSING_TOKEN => self::HTTP_UNAUTHORIZED,
            self::ERROR_INVALID_SIGNATURE => self::HTTP_UNAUTHORIZED,
            self::ERROR_UNSUPPORTED_EVENT => self::HTTP_BAD_REQUEST,
            self::ERROR_INVALID_PAYLOAD => self::HTTP_BAD_REQUEST,
            self::ERROR_MISSING_REQUIRED_FIELD => self::HTTP_BAD_REQUEST,
            self::ERROR_RATE_LIMIT_EXCEEDED => self::HTTP_TOO_MANY_REQUESTS,
            self::ERROR_REQUEST_TIMEOUT => self::HTTP_REQUEST_TIMEOUT,
        ];

        return $errorMap[$errorCode] ?? self::HTTP_INTERNAL_SERVER_ERROR;
    }

    private function logError(\Exception $e)
    {
        LogContext::set('error', [
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);

        log_message('error', '[Webhook] Erro: {context}', ['context' => LogContext::toJson()]);
    }

    private function clearProvidersCache()
    {
        if ($this->cache->delete('webhook_providers')) {
            log_message('info', 'Cache de providers limpo com sucesso');
        } else {
            log_message('error', 'Erro ao limpar cache de providers');
        }
    }

    public function clearCache_post(): void
    {
        try {
            log_message('debug', '[Debug] iniciando a rota clearCache_post');

            LogContext::clear();
            LogContext::set('request_id', uniqid('webhook_cache_'));

            $token = $this->input->get_request_header('Admin-Token');
            
            if (!$token) {
                throw new \Exception('Token de autenticação não informado', self::HTTP_UNAUTHORIZED);
            }

            $this->config->load('webhook_providers');
            $adminToken = $this->config->item('webhook_admin')['token'];

            if (!$adminToken || $token !== $adminToken) {
                throw new \Exception('Token inválido', self::HTTP_UNAUTHORIZED);
            }

            $this->executeWithTimeout(
                fn() => $this->clearProvidersCache(),
                $this->config->item('webhook_admin')['timeout']['long']
            );
            
            $this->response([
                'status' => 'success',
                'message' => 'Cache limpo com sucesso',
                'request_id' => LogContext::get('request_id')
            ], self::HTTP_OK);

        } catch (\Exception $e) {
            $this->logError($e);
            $this->handleError($e);
        }
    }
}