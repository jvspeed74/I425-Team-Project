<?php

declare(strict_types=1);

use App\Controllers\CarController;
use App\Models\Car;
use App\Repositories\CarRepository;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

covers(CarController::class);

afterEach(function () {
    Mockery::close();
});

test('get all cars', function () {
    $carRepository = Mockery::mock(CarRepository::class);
    $mockCars = Mockery::mock(EloquentCollection::class);
    $mockCars->shouldReceive('toJson')->andReturn('[]');

    $carRepository->shouldReceive('getAll')
        ->once()
        ->andReturn($mockCars);

    $controller = new CarController($carRepository);
    $response = new Response();
    $result = $controller->getAll($response);

    expect($result->getStatusCode())
        ->toBe(200)
        ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
        ->and((string) $result->getBody())->toBe('[]');
});

test('get car by id', function () {
    $carRepository = Mockery::mock(CarRepository::class);
    $mockCar = Mockery::mock(Car::class);
    $mockCar->shouldReceive('toJson')->andReturn('{"id": 1, "make": "Toyota", "model": "Corolla"}');

    $carRepository->shouldReceive('getById')
        ->with(1)
        ->once()
        ->andReturn($mockCar);

    $controller = new CarController($carRepository);
    $response = new Response();
    $result = $controller->getById($response, 1);

    expect($result->getStatusCode())
        ->toBe(200)
        ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
        ->and((string) $result->getBody())->toBe('{"id": 1, "make": "Toyota", "model": "Corolla"}');
});

test('create car', function () {
    $carRepository = Mockery::mock(CarRepository::class);
    $request = Mockery::mock(Request::class);
    $request->shouldReceive('getParsedBody')->once()->andReturn([
        'make' => 'Toyota',
        'model' => 'Corolla',
    ]);

    $mockCar = Mockery::mock(Car::class);
    $mockCar->shouldReceive('toJson')->andReturn('{"id": 1, "make": "Toyota", "model": "Corolla"}');

    $carRepository->shouldReceive('create')
        ->with(['make' => 'Toyota', 'model' => 'Corolla'])
        ->once()
        ->andReturn($mockCar);

    $controller = new CarController($carRepository);
    $response = new Response();
    $result = $controller->create($request, $response);

    expect($result->getStatusCode())
        ->toBe(201)
        ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
        ->and((string) $result->getBody())->toBe('{"id": 1, "make": "Toyota", "model": "Corolla"}');
});

test('update car', function () {
    $carRepository = Mockery::mock(CarRepository::class);
    $request = Mockery::mock(Request::class);
    $request->shouldReceive('getParsedBody')->once()->andReturn([
        'make' => 'Toyota',
        'model' => 'Corolla',
    ]);

    $mockCar = Mockery::mock(Car::class);
    $mockCar->shouldReceive('toJson')->andReturn('{"id": 1, "make": "Toyota", "model": "Corolla"}');

    $carRepository->shouldReceive('update')
        ->with(1, ['make' => 'Toyota', 'model' => 'Corolla'])
        ->once()
        ->andReturn($mockCar);

    $controller = new CarController($carRepository);
    $response = new Response();
    $result = $controller->update($request, $response, 1);

    expect($result->getStatusCode())
        ->toBe(200)
        ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
        ->and((string) $result->getBody())->toBe('{"id": 1, "make": "Toyota", "model": "Corolla"}');
});

test('delete car', function () {
    $carRepository = Mockery::mock(CarRepository::class);

    $carRepository->shouldReceive('delete')
        ->with(1)
        ->once()
        ->andReturn(true);

    $controller = new CarController($carRepository);
    $response = new Response();
    $result = $controller->delete($response, 1);

    expect($result->getStatusCode())->toBe(204);
});
