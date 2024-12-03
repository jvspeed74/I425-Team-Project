<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Enums\HTTPStatusCode;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Factory\ResponseFactory;

class ResponseHandler
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function createResponse(HTTPStatusCode $statusCode): ResponseInterface
    {
        return $this->responseFactory->createResponse($statusCode->value);
    }

    /**
     * @throws \JsonException
     */
    public function unauthorized(string $message): ResponseInterface
    {
        $response = $this->createResponse(HTTPStatusCode::UNAUTHORIZED);
        $response->getBody()->write(
            json_encode(['error' => $message], JSON_THROW_ON_ERROR),
        );
        return $response;
    }
}
