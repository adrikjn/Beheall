
<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    public function __invoke(Request $request, callable $next)
    {
        // Exécutez la prochaine étape du middleware, généralement le contrôleur
        $response = $next($request);

        // Configurez les en-têtes CORS
        $response->headers->set('Access-Control-Allow-Origin', 'https://www.beheall.com');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        // Permettre les cookies si nécessaire
        // $response->headers->set('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
