<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Authentication\BasicAuthenticator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;

class CustomHeaderAuthMiddleware implements MiddlewareInterface
{
    private BasicAuthenticator $basicAuthenticator;

    public function __construct(BasicAuthenticator $basicAuthenticator)
    {
        $this->basicAuthenticator = $basicAuthenticator;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler,
    ): ResponseInterface {
        $authHeader = $request->getHeader('F1-API-Authorization');
        if (empty($authHeader) || !str_starts_with($authHeader[0], 'Basic ')) {
            throw new HttpUnauthorizedException(
                $request,
                'Basic credentials not received',
            );
        }

        $credentials = base64_decode(str_replace('Basic ', '', $authHeader[0]));
        [$username, $password] = explode(':', $credentials, 2);
        if (!$this->basicAuthenticator->validate($username, $password)) {
            throw new HttpUnauthorizedException($request, 'Invalid credentials');
        }

        return $handler->handle($request);
    }
}
