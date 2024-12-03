<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Helpers\ResponseHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    private BearerAuthMiddleware $bearerAuthMiddleware;
    private BasicAuthMiddleware $basicAuthMiddleware;
    private JWTAuthMiddleware $jwtAuthMiddleware;
    private ResponseHandler $responseHandler;

    public function __construct(
        BearerAuthMiddleware $bearerAuthMiddleware,
        BasicAuthMiddleware $basicAuthMiddleware,
        JWTAuthMiddleware $jwtAuthMiddleware,
        ResponseHandler $responseHandler,
    ) {
        $this->bearerAuthMiddleware = $bearerAuthMiddleware;
        $this->basicAuthMiddleware = $basicAuthMiddleware;
        $this->jwtAuthMiddleware = $jwtAuthMiddleware;
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
        if (empty($authHeader)) {
            return $this->responseHandler->unauthorized(
                'Authorization header not received',
            );
        }

        if (str_starts_with($authHeader[0], 'Bearer ')) {
            return $this->bearerAuthMiddleware->process($request, $handler);
        }

        if (str_starts_with($authHeader[0], 'Basic ')) {
            return $this->basicAuthMiddleware->process($request, $handler);
        }

        if (str_starts_with($authHeader[0], 'JWT ')) {
            return $this->jwtAuthMiddleware->process($request, $handler);
        }

        return $this->responseHandler->unauthorized('Invalid authorization header');
    }

}
