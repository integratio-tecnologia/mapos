<?php

defined('BASEPATH') or exit('No direct script access allowed');

class RateLimiter
{
    protected $ci;
    protected $cache;
    protected $config;

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->driver('cache', ['adapter' => 'file']);
        $this->cache = $this->ci->cache;
        
        // Carrega configurações
        $this->ci->config->load('webhook_providers');
        $this->config = $this->ci->config->item('webhook_admin')['rate_limit'] ?? [
            'max_requests' => 100,  // requisições máximas por janela
            'window' => 3600        // janela de tempo em segundos (1 hora)
        ];
    }

    /**
     * Verifica se o limite de requisições foi atingido
     */
    public function check(string $key): bool
    {
        $cacheKey = "rate_limit:{$key}";
        $attempts = $this->cache->get($cacheKey) ?: 0;

        if ($attempts >= $this->config['max_requests']) {
            return false;
        }

        $this->cache->save($cacheKey, $attempts + 1, $this->config['window']);
        return true;
    }

    /**
     * Retorna o número de tentativas restantes
     */
    public function getRemainingAttempts(string $key): int
    {
        $cacheKey = "rate_limit:{$key}";
        $attempts = $this->cache->get($cacheKey) ?: 0;
        return max(0, $this->config['max_requests'] - $attempts);
    }

    /**
     * Retorna o tempo em segundos para reset do contador
     */
    public function getResetTime(string $key): int
    {
        $cacheKey = "rate_limit:{$key}";
        return $this->cache->get_metadata($cacheKey)['expire'] ?? 0;
    }
}