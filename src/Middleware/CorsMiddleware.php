<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    public function __invoke(Request $request, Response $response)
    {
        $response->headers->set('Access-Control-Allow-Origin', 'https://www.beheall.com');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        // Allow credentials if needed
        // $response->headers->set('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
