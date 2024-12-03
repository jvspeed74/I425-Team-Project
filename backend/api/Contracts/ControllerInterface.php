<?php

declare(strict_types=1);

namespace App\Contracts;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

interface ControllerInterface
{
    public function getAll(Response $response): Response;
    public function getById(Response $response, int $id): Response;
    public function create(Request $request, Response $response): Response;
    public function update(Request $request, Response $response, int $id): Response;
    public function delete(Response $response, int $id): Response;
}
