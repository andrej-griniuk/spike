<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Https middleware
 */
class HttpsMiddleware
{

    /**
     * Invoke method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Message\ResponseInterface $response The response.
     * @param callable $next Callback to invoke the next middleware.
     * @return \Psr\Http\Message\ResponseInterface A response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        $uri = $request->getUri();

        if ($uri->getHost() != 'localhost' && $uri->getScheme() != 'https') {
            $location = str_replace('http://', 'https://', (string)$uri);

            $response = $response
                ->withHeader('Location', $location)
                ->withHeader('Status', 302);
        }

        return $next($request, $response);
    }
}
