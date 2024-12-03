<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Authentication\BasicAuthenticator;
use App\Helpers\ResponseHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BasicAuthMiddleware implements MiddlewareInterface
{
    private BasicAuthenticator $basicAuthenticator;
    private ResponseHandler $responseHandler;

    public function __construct(
        BasicAuthenticator $basicAuthenticator,
        ResponseHandler $responseHandler,
    ) {
        $this->basicAuthenticator = $basicAuthenticator;
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
        if (empty($authHeader) || !str_starts_with($authHeader[0], 'Basic ')) {
            return $this->responseHandler->unauthorized('Basic credentials not received');
        }

        $credentials = base64_decode(str_replace('Basic ', '', $authHeader[0]));
        [$username, $password] = explode(':', $credentials, 2);
        if (!$this->basicAuthenticator->validate($username, $password)) {
            return $this->responseHandler->unauthorized('Invalid credentials');
        }

        return $handler->handle($request);
    }
}
