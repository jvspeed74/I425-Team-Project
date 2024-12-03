<?php

declare(strict_types=1);

namespace backend\tests\Unit\Controllers;

use App\Contracts\AbstractController;
use App\Contracts\AbstractRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Mockery;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

covers(AbstractController::class);


beforeEach(function () {
    $this->repository = Mockery::mock(AbstractRepository::class);
    $this->controller = new class ($this->repository) extends AbstractController {
        public function __construct(AbstractRepository $repository)
        {
            parent::__construct($repository);
        }
    };
    $this->response = new Response();
    $this->collection = Mockery::mock(Collection::class);
    $this->model = Mockery::mock(Model::class);
    $this->mockRequest = Mockery::mock(Request::class);
});

afterEach(function () {
    Mockery::close();
});

describe('getAll', function () {
    it(
        'returns a 200 status code and an empty JSON array when no items are found',
        function () {
            $this->repository
                ->shouldReceive('getAll')
                ->once()
                ->andReturn($this->collection);
            $this->collection
                ->shouldReceive('toJson')
                ->once()
                ->andReturn('[]');

            $result = $this->controller->getAll($this->response);

            expect($result->getStatusCode())
                ->toBe(200)
                ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
                ->and((string) $result->getBody())->toBe('[]');
        },
    );
});

describe('getById', function () {
    it(
        'returns a 200 status code and the item as JSON when the item is found',
        function () {
            $this->repository->shouldReceive('getById')->with(1)->once()->andReturn(
                $this->model,
            );
            $this->model->shouldReceive('toJson')->once()->andReturn(
                '{"id": 1, "name": "Item A"}',
            );

            $result = $this->controller->getById($this->response, 1);

            expect($result->getStatusCode())
                ->toBe(200)
                ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
                ->and((string) $result->getBody())->toBe('{"id": 1, "name": "Item A"}');
        },
    );

    it(
        'returns a 404 status code and an error message when the item is not found',
        function () {
            $this->repository->shouldReceive('getById')->with(1)->once()->andReturn(
                false,
            );

            $result = $this->controller->getById($this->response, 1);

            expect($result->getStatusCode())
                ->toBe(404)
                ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
                ->and((string) $result->getBody())->toBe('{"message":"Item not found"}');
        },
    );
});

describe('create', function () {
    it(
        'creates a new item and returns a 201 status code with the created item as JSON',
        function () {
            $this->mockRequest->shouldReceive('getParsedBody')->once()->andReturn(
                ['name' => 'Item A'],
            );
            $this->repository
                ->shouldReceive('create')
                ->with(['name' => 'Item A'])
                ->once()
                ->andReturn($this->model);
            $this->model->shouldReceive('toJson')->once()->andReturn(
                '{"id": 1, "name": "Item A"}',
            );

            $result = $this->controller->create($this->mockRequest, $this->response);

            expect($result->getStatusCode())
                ->toBe(201)
                ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
                ->and((string) $result->getBody())->toBe('{"id": 1, "name": "Item A"}');
        },
    );

    it(
        'returns a 400 status code and an error message when the request body is invalid',
        function () {
            $this->mockRequest->shouldReceive('getParsedBody')->once()->andReturn(null);

            $result = $this->controller->create($this->mockRequest, $this->response);

            expect($result->getStatusCode())
                ->toBe(400)
                ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
                ->and((string) $result->getBody())->toBe(
                    '{"message":"Invalid JSON body"}',
                );
        },
    );
});

describe('update', function () {})->todo();
describe('delete', function () {})->todo();
