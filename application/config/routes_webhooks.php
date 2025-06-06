<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

// Rotas para Webhooks
$route['api/v1/webhooks/(:any)'] = 'api/v1/webhooks/WebhooksController/index/$1';