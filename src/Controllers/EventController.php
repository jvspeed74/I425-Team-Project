<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\EventRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class EventController
{
    protected EventRepository $eventRepository;

    // Inject the repository via constructor
    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    // Fetch all teams

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function getAllEvents(Request $request, Response $response): Response
    {
        $events = $this->eventRepository->getAllEvents();
        $response->getBody()->write($events->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Fetch a event by ID

    /**
     * @param Request $request
     * @param Response $response
     * @param string[] $args
     * @return Response
     * @throws \JsonException
     */
    public function getEventById(Request $request, Response $response, array $args): Response
    {
        // Extract the ID from the request arguments
        $id = (int) $args['id'];

        // Send the ID to the repository to fetch the event from the database
        $event = $this->eventRepository->getEventById($id);

        // If the event was not found, return a 404 response
        if (!$event) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Event not found"], JSON_THROW_ON_ERROR));
            return $response;
        }

        // Return the event as JSON
        $response->getBody()->write($event->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \JsonException
     */
    public function createEvent(Request $request, Response $response): Response
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

        // Send the filtered data to the repository to create the event in the database
        // TODO Filter the data before sending it to the repository
        $event = $this->eventRepository->createEvent($data);

        // Return the created event as JSON with a 201 status code
        $response->getBody()->write($event->toJson());
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }

    // Update an event by ID

    /**
     * @param Request $request
     * @param Response $response
     * @param string[] $args
     * @return Response
     * @throws \JsonException
     */
    public function updateEvent(Request $request, Response $response, array $args): Response
    {
        // Extract the ID from the request arguments
        $id = (int) $args['id'];

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

        // Send the filtered data to the repository to update the event in the database
        // TODO Filter the data before sending it to the repository
        $event = $this->eventRepository->updateEvent($id, $data);

        // If the update was not successful, return a 404 response
        if (!$event) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Event not found"], JSON_THROW_ON_ERROR));
            return $response;
        }

        // Return the updated event as JSON
        $response->getBody()->write($event->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param string[] $args
     * @return Response
     * @throws \JsonException
     */
    public function deleteEvent(Request $request, Response $response, array $args): Response
    {
        // Extract the ID from the request arguments
        $id = (int) $args['id'];

        // Send the ID to the repository to delete the event from the database
        $deleted = $this->eventRepository->deleteEvent($id);

        // If the event was not found, return a 404 response
        if (!$deleted) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Event not found"], JSON_THROW_ON_ERROR));
            return $response;
        }

        // Return a 204 response (no content) if the event was successfully deleted
        return $response->withStatus(204)->withHeader('Content-Type', 'application/json');
    }
}
