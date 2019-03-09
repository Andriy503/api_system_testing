<?php

namespace App\Middleware;

use Cake\Core\Configure;
use Cake\Log\Log;

class CorsMiddleware
{
    public function __invoke($request, $response, $next)
    {
        $response = $response
            ->withHeader('Origin', Configure::read('CORS.accessControlAllowOrigin', ''))
            ->withHeader('Access-Control-Allow-Origin', Configure::read('CORS.accessControlAllowOrigin', '*'))
            ->withHeader('Access-Control-Allow-Methods', Configure::read('CORS.accessControlAllowMethods', 'POST, GET, OPTIONS, PUT'))
            ->withHeader('Access-Control-Allow-Headers', Configure::read('CORS.accessControlAllowHeaders', 'Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With'))
            ->withHeader('Access-Control-Allow-Credentials', Configure::read('CORS.accessControlAllowCredentials', 'false'));

        if ($request->is('options')) {
            return $response;
        }

        return $next($request, $response);
    }
}
