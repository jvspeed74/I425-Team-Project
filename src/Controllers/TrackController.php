<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

declare(strict_types=1);

namespace App\Controllers;

use App\Interfaces\TrackControllerInterface;
use App\Repositories\TrackRepository;
use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TrackController implements TrackControllerInterface
{
    protected TrackRepository $trackRepository;

    // Inject the repository via constructor
    public function __construct(TrackRepository $trackRepository)
    {
        $this->trackRepository = $trackRepository;
    }

    // Fetch all tracks

    /**
     * @param Response $response
     * @param Request $request
     * @return Response
     */
    public function getAllTracks(Request $request, Response $response): Response
    {
        $page = (int) $request->getQueryParam('page', 1);
        $limit = (int) $request->getQueryParam('limit', 10);
        $sortBy = $request->getQueryParam('sort_by', 'id');
        $order = $request->getQueryParam('order', 'asc');

        if ($page < 1) {
            return $response->withStatus(400)->write('Invalid page number. Must be greater than 0.');
        }

        if ($limit < 1 || $limit > 100) {
            return $response->withStatus(400)->write('Invalid limit. Must be between 1 and 100.');
        }

        if (!in_array($order, ['asc', 'desc'], true)) {
            return $response->withStatus(400)->write('Invalid order. Must be "asc" or "desc".');
        }

        try {
            $tracks = $this->trackRepository->getAllTracks($page, $limit, $sortBy, $order);

            $totalCount = $this->trackRepository->getTotalCount();
            $totalPages = ceil($totalCount / $limit);

            $response->getBody()->write($tracks->toJson());

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withHeader('X-Total-Count', (string) $totalCount)
                ->withHeader('X-Total-Pages', (string) $totalPages)
                ->withHeader('X-Current-Page', (string) $page)
                ->withHeader('X-Items-Per-Page', (string) $limit);
        } catch (\Exception $e) {
            return $response->withStatus(500)->write('Internal Server Error: ' . $e->getMessage());
        }
    }

    // Fetch a track by ID

    /**
     * @param Response $response
     * @param int $id
     * @return Response
     * @throws JsonException
     */
    public function getTrackById(Response $response, int $id): Response
    {
        // Send the ID to the repository to fetch the track from the database
        $track = $this->trackRepository->getTrackById($id);

        // If the track was not found, return a 404 response
        if (!$track) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Track not found"], JSON_THROW_ON_ERROR));
            return $response;
        }

        // Return the track as JSON
        $response->getBody()->write($track->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws JsonException
     */
    public function createTrack(Request $request, Response $response): Response
    {
        // getParsedBody can return array|object|null based on the Content-Type header
        // Since the content type is application/json, it will return an array OR an object
        // We need to handle both cases by converting the object to an array
        $data = $request->getParsedBody();

        // If the body is not valid JSON, return a 400 response
        if ($data === null) {
            $response = $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Invalid JSON body"], JSON_THROW_ON_ERROR));
            return $response;
        }

        // Convert object to array if necessary
        if (is_object($data)) {
            $data = (array) $data;
        }

        // Send the filtered data to the repository to create the track in the database
        // TODO Filter the data before sending it to the repository
        $track = $this->trackRepository->createTrack($data);

        // Return the created track as JSON with a 201 status code
        $response->getBody()->write($track->toJson());
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }

    // Update a track by ID

    /**
     * @param Request $request
     * @param Response $response
     * @param int $id
     * @return Response
     * @throws JsonException
     */
    public function updateTrack(Request $request, Response $response, int $id): Response
    {
        // getParsedBody can return array|object|null based on the Content-Type header
        // Since the content type is application/json, it will return an array OR an object
        // We need to handle both cases by converting the object to an array
        $data = $request->getParsedBody();

        // If the body is not valid JSON, return a 400 response
        if ($data === null) {
            $response = $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Invalid JSON body"], JSON_THROW_ON_ERROR));
            return $response;
        }

        // Convert object to array if necessary
        if (is_object($data)) {
            $data = (array) $data;
        }

        // Send the filtered data to the repository to update the track in the database
        // TODO Filter the data before sending it to the repository
        $track = $this->trackRepository->updateTrack($id, $data);

        // If the update was not successful, return a 404 response
        if (!$track) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Track not found"], JSON_THROW_ON_ERROR));
            return $response;
        }

        // Return the updated track as JSON
        $response->getBody()->write($track->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Response $response
     * @param int $id
     * @return Response
     * @throws JsonException
     */
    public function deleteTrack(Response $response, int $id): Response
    {
        // Send the ID to the repository to delete the track from the database
        $deleted = $this->trackRepository->deleteTrack($id);

        // If the track was not found, return a 404 response
        if (!$deleted) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Track not found"], JSON_THROW_ON_ERROR));
            return $response;
        }

        // Return a 204 response (no content) if the track was successfully deleted
        return $response->withStatus(204)->withHeader('Content-Type', 'application/json');
    }
}
