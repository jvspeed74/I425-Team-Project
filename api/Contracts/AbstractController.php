<?php

declare(strict_types=1);

namespace App\Contracts;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class AbstractController implements ControllerInterface
{
    protected AbstractRepository $repository;

    public function __construct(AbstractRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(Response $response): Response
    {
        $items = $this->repository->getAll();
        $response->getBody()->write($items->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getById(Response $response, int $id): Response
    {
        $item = $this->repository->getById($id);
        if ($item === false) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Item not found"], JSON_THROW_ON_ERROR));
            return $response;
        }
        $response->getBody()->write($item->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        if ($data === null) {
            $response = $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Invalid JSON body"], JSON_THROW_ON_ERROR));
            return $response;
        }
        if (is_object($data)) {
            $data = (array) $data;
        }
        $item = $this->repository->create($data);
        $response->getBody()->write($item->toJson());
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }

    public function update(Request $request, Response $response, int $id): Response
    {
        $data = $request->getParsedBody();
        if ($data === null) {
            $response = $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Invalid JSON body"], JSON_THROW_ON_ERROR));
            return $response;
        }
        if (is_object($data)) {
            $data = (array) $data;
        }
        $item = $this->repository->update($id, $data);
        if ($item === false) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Item not found"], JSON_THROW_ON_ERROR));
            return $response;
        }
        $response->getBody()->write($item->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function delete(Response $response, int $id): Response
    {
        $deleted = $this->repository->delete($id);
        if (!$deleted) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Item not found"], JSON_THROW_ON_ERROR));
            return $response;
        }
        return $response->withStatus(204)->withHeader('Content-Type', 'application/json');
    }
}
