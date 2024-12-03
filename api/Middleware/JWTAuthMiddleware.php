<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Authentication\JWTAuthenticator;
use App\Helpers\ResponseHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JWTAuthMiddleware implements MiddlewareInterface
{
    private JWTAuthenticator $jwtAuthenticator;
    private ResponseHandler $responseHandler;

    public function __construct(
        JWTAuthenticator $jwtAuthenticator,
        ResponseHandler $responseHandler,
    ) {
        $this->jwtAuthenticator = $jwtAuthenticator;
        $this->responseHandler = $responseHandler;
    }

    /**
     * @throws \JsonException
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler,
    ): ResponseInterface {
        $authHeader = $request->getHeader('Authorization');
        if (empty($authHeader) || !str_starts_with($authHeader[0], 'JWT ')) {
            return $this->responseHandler->unauthorized('JWT token not received');
        }

        $token = str_replace('JWT ', '', $authHeader[0]);
        if (!$this->jwtAuthenticator->validate($token)) {
            return $this->responseHandler->unauthorized('Invalid');
        }

        return $handler->handle($request);
    }
}
