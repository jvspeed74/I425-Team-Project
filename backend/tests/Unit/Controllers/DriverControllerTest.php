<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers;

use App\Controllers\DriverController;
use App\Repositories\DriverRepository;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

covers(DriverController::class);

beforeEach(function () {
    $this->repository = Mockery::mock(DriverRepository::class);
    $this->collection = Mockery::mock(Collection::class);
    $this->request = Mockery::mock(Request::class);
    $this->controller = new DriverController($this->repository);
});

afterEach(function () {
    Mockery::close();
});

describe('search', function () {
    it(
        'returns a 400 status code and a JSON error message when no search query is provided',
        function () {
            $this->request
                ->shouldReceive('getQueryParams')
                ->once()
                ->andReturn([]);

            $result = $this->controller->search($this->request, new Response());

            expect($result->getStatusCode())
                ->toBe(400)
                ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
                ->and((string) $result->getBody())->toBe(
                    '{"message":"Missing search query"}',
                );
        },
    );

    it(
        'returns a 200 status code and a JSON array of drivers when a search query is provided',
        function () {
            $this->request
                ->shouldReceive('getQueryParams')
                ->once()
                ->andReturn(['q' => 'John Doe']);

            $this->repository
                ->shouldReceive('search')
                ->with('John Doe')
                ->once()
                ->andReturn($this->collection);

            $this->collection
                ->shouldReceive('toJson')
                ->once()
                ->andReturn('[]');

            $result = $this->controller->search($this->request, new Response());

            expect($result->getStatusCode())
                ->toBe(200)
                ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
                ->and((string) $result->getBody())->toBe('[]');
        },
    );
});
