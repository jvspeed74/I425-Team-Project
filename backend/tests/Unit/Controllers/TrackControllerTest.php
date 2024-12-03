<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers;

use App\Controllers\TrackController;
use App\Repositories\TrackRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

covers(TrackController::class);

beforeEach(function () {
    $this->repository = Mockery::mock(TrackRepository::class);
    $this->collection = Mockery::mock(Collection::class);
    $this->request = Mockery::mock(Request::class);
    $this->controller = new TrackController($this->repository);
    $this->paginator = Mockery::mock(LengthAwarePaginator::class);
});

afterEach(function () {
    Mockery::close();
});

describe('getAllWithParams', function () {
    it('returns paginated results with valid parameters', function () {
        $this->request
            ->shouldReceive('getQueryParams')
            ->andReturn(
                ['page' => '2', 'limit' => '5', 'sort_by' => 'name', 'order' => 'desc'],
            );

        $tracksData = [['name' => 'Track 1'], ['name' => 'Track 2']];
        $this->collection->shouldReceive('items')->andReturn($tracksData);

        $this->repository
            ->shouldReceive('getAllWithParams')
            ->with(2, 5, 'name', 'desc')
            ->andReturn($this->paginator);

        $this->repository
            ->shouldReceive('getAll')
            ->andReturn($this->collection);

        $this->collection
            ->shouldReceive('count')
            ->andReturn(10);

        $this->paginator
            ->shouldReceive('items')
            ->andReturn($tracksData);

        $response = Mockery::mock(Response::class);

        $response
            ->shouldReceive('getBody->write')
            ->with(json_encode($tracksData, JSON_THROW_ON_ERROR));

        $response
            ->shouldReceive('withHeader')
            ->withArgs(['Content-Type', 'application/json'])
            ->andReturnSelf();

        $response
            ->shouldReceive('withHeader')
            ->withArgs(['X-Total-Count', Mockery::type('string')])
            ->andReturnSelf();

        $response
            ->shouldReceive('withHeader')
            ->withArgs(['X-Total-Pages', Mockery::type('string')])
            ->andReturnSelf();

        $response
            ->shouldReceive('withHeader')
            ->withArgs(['X-Current-Page', '2'])
            ->andReturnSelf();

        $response
            ->shouldReceive('withHeader')
            ->withArgs(['X-Items-Per-Page', '5'])
            ->andReturnSelf();

        $result = $this->controller->getAllWithParams(
            $this->request,
            $response,
        );

        expect($result)->toBeInstanceOf(Response::class);
    });

    it('returns 400 for invalid page number', function () {
        $this->request
            ->shouldReceive('getQueryParams')
            ->andReturn(
                ['page' => '0', 'limit' => '5', 'sort_by' => 'name', 'order' => 'asc'],
            );

        $response = Mockery::mock(Response::class);
        $response->shouldReceive('getBody->write')->with(
            json_encode(
                ['message' => 'Invalid page number. Must be greater than 0.'],
                JSON_THROW_ON_ERROR,
            ),
        );
        $response->shouldReceive('withStatus')->with(400)->andReturnSelf();
        $response->shouldReceive('withHeader')->withArgs(
            ['Content-Type', 'application/json'],
        )->andReturnSelf();

        $actualResponse = $this->controller->getAllWithParams(
            $this->request,
            $response,
        );

        expect($actualResponse)->toBeInstanceOf(Response::class);
    });

    it('returns 400 for invalid limit', function () {
        $this->request
            ->shouldReceive('getQueryParams')
            ->andReturn(
                [
                    'page' => '1',
                    'limit' => '101',
                    'sort_by' => 'name',
                    'order' => 'asc',
                ],
            );

        $response = Mockery::mock(Response::class);
        $response->shouldReceive('getBody->write')->with(
            json_encode(
                ['message' => 'Invalid limit. Must be between 1 and 100.'],
                JSON_THROW_ON_ERROR,
            ),
        );
        $response->shouldReceive('withStatus')->with(400)->andReturnSelf();
        $response->shouldReceive('withHeader')->withArgs(
            ['Content-Type', 'application/json'],
        )->andReturnSelf();

        $actualResponse = $this->controller->getAllWithParams(
            $this->request,
            $response,
        );

        expect($actualResponse)->toBeInstanceOf(Response::class);
    });

    it('returns 400 for invalid sort field', function () {
        $this->request
            ->shouldReceive('getQueryParams')
            ->andReturn(
                [
                    'page' => '1',
                    'limit' => '10',
                    'sort_by' => 'invalid_field',
                    'order' => 'asc',
                ],
            );

        $response = Mockery::mock(Response::class);
        $response->shouldReceive('getBody->write')->with(
            json_encode(
                ['message' => 'Invalid sort field: invalid_field'],
                JSON_THROW_ON_ERROR,
            ),
        );
        $response->shouldReceive('withStatus')->with(400)->andReturnSelf();
        $response->shouldReceive('withHeader')->withArgs(
            ['Content-Type', 'application/json'],
        )->andReturnSelf();

        $actualResponse = $this->controller->getAllWithParams(
            $this->request,
            $response,
        );

        expect($actualResponse)->toBeInstanceOf(Response::class);
    });

    it('returns 400 for invalid order', function () {
        $this->request
            ->shouldReceive('getQueryParams')
            ->andReturn(
                [
                    'page' => '1',
                    'limit' => '10',
                    'sort_by' => 'id',
                    'order' => 'invalid_order',
                ],
            );

        $response = Mockery::mock(Response::class);
        $response->shouldReceive('getBody->write')->with(
            json_encode(
                ['message' => 'Invalid order. Must be "asc" or "desc".'],
                JSON_THROW_ON_ERROR,
            ),
        );
        $response->shouldReceive('withStatus')->with(400)->andReturnSelf();
        $response->shouldReceive('withHeader')->withArgs(
            ['Content-Type', 'application/json'],
        )->andReturnSelf();

        $actualResponse = $this->controller->getAllWithParams(
            $this->request,
            $response,
        );

        expect($actualResponse)->toBeInstanceOf(Response::class);
    });
});
