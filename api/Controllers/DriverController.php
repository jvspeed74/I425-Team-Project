<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\AbstractController;
use App\Repositories\DriverRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DriverController extends AbstractController
{
    public function __construct(DriverRepository $driverRepository)
    {
        parent::__construct($driverRepository);
    }

    public function search(Request $request, Response $response): Response
    {
        /** @var ?string $q */
        $q = $request->getQueryParams()['q'] ?? null;

        if ($q === null) {
            $response = $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Missing search query"], JSON_THROW_ON_ERROR));
            return $response;
        }

        $drivers = $this->repository->search($q);
        $response->getBody()->write($drivers->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }
}
