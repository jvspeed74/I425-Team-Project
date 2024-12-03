<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Authentication\BearerAuthenticator;
use App\Helpers\ResponseHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BearerAuthMiddleware implements MiddlewareInterface
{
    private BearerAuthenticator $bearerAuthenticator;
    private ResponseHandler $responseHandler;

    public function __construct(
        BearerAuthenticator $bearerAuthenticator,
        ResponseHandler $responseHandler,
    ) {
        $this->bearerAuthenticator = $bearerAuthenticator;
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
        if (empty($authHeader) || !str_starts_with($authHeader[0], 'Bearer ')) {
            return $this->responseHandler->unauthorized('Bearer token not received');
        }

        $token = str_replace('Bearer ', '', $authHeader[0]);
        if (!$this->bearerAuthenticator->validate($token)) {
            return $this->responseHandler->unauthorized('Invalid token');
        }

        return $handler->handle($request);
    }
}
