<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\TeamRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TeamController
{
    protected TeamRepository $teamRepository;

    // Inject the repository via constructor
    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    // Fetch all teams

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function getAllTeams(Request $request, Response $response): Response
    {
        $teams = $this->teamRepository->getAllTeams();
        $response->getBody()->write($teams->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Fetch a team by ID

    /**
     * @param Request $request
     * @param Response $response
     * @param string[] $args
     * @return Response
     * @throws \JsonException
     */
    public function getTeamById(Request $request, Response $response, array $args): Response
    {
        // Extract the ID from the request arguments
        $id = (int) $args['id'];

        // Send the ID to the repository to fetch the team from the database
        $team = $this->teamRepository->getTeamById($id);

        // If the team was not found, return a 404 response
        if (!$team) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Team not found"], JSON_THROW_ON_ERROR));
            return $response;
        }

        // Return the team as JSON
        $response->getBody()->write($team->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \JsonException
     */
    public function createTeam(Request $request, Response $response): Response
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

        // Send the filtered data to the repository to create the team in the database
        // TODO Filter the data before sending it to the repository
        $team = $this->teamRepository->createTeam($data);

        // Return the created team as JSON with a 201 status code
        $response->getBody()->write($team->toJson());
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }

    // Update a team by ID

    /**
     * @param Request $request
     * @param Response $response
     * @param string[] $args
     * @return Response
     * @throws \JsonException
     */
    public function updateTeam(Request $request, Response $response, array $args): Response
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

        // Send the filtered data to the repository to update the team in the database
        // TODO Filter the data before sending it to the repository
        $team = $this->teamRepository->updateTeam($id, $data);

        // If the update was not successful, return a 404 response
        if (!$team) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Team not found"], JSON_THROW_ON_ERROR));
            return $response;
        }

        // Return the updated team as JSON
        $response->getBody()->write($team->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param string[] $args
     * @return Response
     * @throws \JsonException
     */
    public function deleteTeam(Request $request, Response $response, array $args): Response
    {
        // Extract the ID from the request arguments
        $id = (int) $args['id'];

        // Send the ID to the repository to delete the team from the database
        $deleted = $this->teamRepository->deleteTeam($id);

        // If the team was not found, return a 404 response
        if (!$deleted) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Team not found"], JSON_THROW_ON_ERROR));
            return $response;
        }

        // Return a 204 response (no content) if the team was successfully deleted
        return $response->withStatus(204)->withHeader('Content-Type', 'application/json');
    }
}
