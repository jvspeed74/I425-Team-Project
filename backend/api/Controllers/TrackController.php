<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\AbstractController;
use App\Repositories\TrackRepository;
use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TrackController extends AbstractController
{
    public function __construct(TrackRepository $trackRepository)
    {
        parent::__construct($trackRepository);
    }

    /**
     * @throws JsonException
     */
    public function getAllWithParams(Request $request, Response $response): Response
    {
        /** @var array{page?: string, limit?: string, sort_by?: string, order?: string } $queryParams */
        $queryParams = $request->getQueryParams();
        $page = (int) ($queryParams['page'] ?? 1);
        $limit = (int) ($queryParams['limit'] ?? 10);
        $sortBy = $queryParams['sort_by'] ?? 'id';
        $order = $queryParams['order'] ?? 'asc';

        if ($page < 1) {
            $response->getBody()->write(json_encode(['message' => 'Invalid page number. Must be greater than 0.'], JSON_THROW_ON_ERROR));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        if ($limit < 1 || $limit > 100) {
            $response->getBody()->write(json_encode(['message' => 'Invalid limit. Must be between 1 and 100.'], JSON_THROW_ON_ERROR));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $trackSortFields = ['id', 'name', 'length_km', 'continent', 'country_id', 'description'];

        if (!in_array($sortBy, $trackSortFields, true)) {
            $response->getBody()->write(json_encode(['message' => 'Invalid sort field: ' . $sortBy], JSON_THROW_ON_ERROR));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        if (!in_array($order, ['asc', 'desc'], true)) {
            $response->getBody()->write(json_encode(['message' => 'Invalid order. Must be "asc" or "desc".'], JSON_THROW_ON_ERROR));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $tracks = $this->repository->getAllWithParams($page, $limit, $sortBy, $order);

        $totalCount = $this->repository->getAll()->count();
        $totalPages = ceil($totalCount / $limit);

        $response->getBody()->write(json_encode($tracks->items(), JSON_THROW_ON_ERROR));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Total-Count', (string) $totalCount)
            ->withHeader('X-Total-Pages', (string) $totalPages)
            ->withHeader('X-Current-Page', (string) $page)
            ->withHeader('X-Items-Per-Page', (string) $limit);
    }
}
