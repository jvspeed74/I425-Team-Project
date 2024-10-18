<?php


declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\CarRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CarController
{
    protected CarRepository $carRepository;

    // Inject the repository via constructor
    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    // Fetch all cars

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function getAllCars(Request $request, Response $response): Response
    {
        $cars = $this->carRepository->getAllCars();
        $response->getBody()->write($cars->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Fetch a car by ID

    /**
     * @param Request $request
     * @param Response $response
     * @param string[] $args
     * @return Response
     * @throws \JsonException
     */
    public function getCarById(Request $request, Response $response, array $args): Response
    {
        // Extract the ID from the request arguments
        $id = (int) $args['id'];

        // Send the ID to the repository to fetch the team from the database
        $car = $this->carRepository->getCarById($id);

        // If the car was not found, return a 404 response
        if (!$car) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Car not found"], JSON_THROW_ON_ERROR));
            return $response;
        }

        // Return the car as JSON
        $response->getBody()->write($car->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \JsonException
     */
    public function createCar(Request $request, Response $response): Response
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

        // Send the filtered data to the repository to create the car in the database
        // TODO Filter the data before sending it to the repository
        $car = $this->carRepository->createCar($data);

        // Return the created team as JSON with a 201 status code
        $response->getBody()->write($car->toJson());
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }

    // Update a car by ID

    /**
     * @param Request $request
     * @param Response $response
     * @param string[] $args
     * @return Response
     * @throws \JsonException
     */
    public function updateCar(Request $request, Response $response, array $args): Response
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
        $car = $this->carRepository->updateCar($id, $data);

        // If the update was not successful, return a 404 response
        if (!$car) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Car not found"], JSON_THROW_ON_ERROR));
            return $response;
        }

        // Return the updated team as JSON
        $response->getBody()->write($car->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param string[] $args
     * @return Response
     * @throws \JsonException
     */
    public function deleteCar(Request $request, Response $response, array $args): Response
    {
        // Extract the ID from the request arguments
        $id = (int) $args['id'];

        // Send the ID to the repository to delete the car from the database
        $deleted = $this->carRepository->deleteCar($id);

        // If the car was not found, return a 404 response
        if (!$deleted) {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(["message" => "Car not found"], JSON_THROW_ON_ERROR));
            return $response;
        }

        // Return a 204 response (no content) if the car was successfully deleted
        return $response->withStatus(204)->withHeader('Content-Type', 'application/json');
    }
}
