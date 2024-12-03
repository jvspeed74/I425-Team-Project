<?php

declare(strict_types=1);

use App\Controllers\TeamController;
use App\Models\Team;
use App\Repositories\TeamRepository;
use Illuminate\Database\Eloquent\Collection;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

covers(TeamController::class);

afterEach(function () {
    Mockery::close();
});

test('get all teams', function () {
    $teamRepository = Mockery::mock(TeamRepository::class);
    $mockTeams = Mockery::mock(Collection::class);
    $mockTeams->shouldReceive('toJson')->andReturn('[]');

    $teamRepository->shouldReceive('getAll')
        ->once()
        ->andReturn($mockTeams);

    $controller = new TeamController($teamRepository);
    $response = new Response();
    $result = $controller->getAll($response);

    expect($result->getStatusCode())
        ->toBe(200)
        ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
        ->and((string) $result->getBody())->toBe('[]');
});

test('get team by id returns team', function () {
    $teamRepository = Mockery::mock(TeamRepository::class);
    $mockTeam = Mockery::mock(Team::class);
    $mockTeam->shouldReceive('toJson')->andReturn('{"id": 1, "official_name": "Team A"}');

    $teamRepository->shouldReceive('getById')
        ->with(1)
        ->once()
        ->andReturn($mockTeam);

    $controller = new TeamController($teamRepository);
    $response = new Response();
    $result = $controller->getById($response, 1);

    expect($result->getStatusCode())
        ->toBe(200)
        ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
        ->and((string) $result->getBody())->toBe('{"id": 1, "official_name": "Team A"}');
});

test('get team by id returns 404 if not found', function () {
    $teamRepository = Mockery::mock(TeamRepository::class);

    $teamRepository->shouldReceive('getById')
        ->with(1)
        ->once()
        ->andReturn(false);

    $controller = new TeamController($teamRepository);
    $response = new Response();
    $result = $controller->getById($response, 1);

    expect($result->getStatusCode())
        ->toBe(404)
        ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
        ->and((string) $result->getBody())->toBe('{"message":"Item not found"}');
});

test('create team', function () {
    $teamRepository = Mockery::mock(TeamRepository::class);
    $mockTeam = Mockery::mock(Team::class);
    $mockTeam->shouldReceive('toJson')->andReturn('{"id": 1, "official_name": "Team A"}');

    $teamRepository->shouldReceive('create')
        ->once()
        ->andReturn($mockTeam);

    $controller = new TeamController($teamRepository);
    $request = Mockery::mock(ServerRequestInterface::class);
    $response = new Response();

    $request->shouldReceive('getParsedBody')
        ->once()
        ->andReturn(['official_name' => 'Team A']);

    $result = $controller->create($request, $response);

    expect($result->getStatusCode())
        ->toBe(201)
        ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
        ->and((string) $result->getBody())->toBe('{"id": 1, "official_name": "Team A"}');
});

test('update team returns updated team', function () {
    $teamRepository = Mockery::mock(TeamRepository::class);
    $mockTeam = Mockery::mock(Team::class);
    $mockTeam->shouldReceive('toJson')->andReturn('{"id": 1, "official_name": "Updated Team"}');

    $teamRepository->shouldReceive('update')
        ->with(1, ['official_name' => 'Updated Team'])
        ->once()
        ->andReturn($mockTeam);

    $controller = new TeamController($teamRepository);
    $request = Mockery::mock(ServerRequestInterface::class);
    $response = new Response();

    $request->shouldReceive('getParsedBody')
        ->once()
        ->andReturn(['official_name' => 'Updated Team']);

    $result = $controller->update($request, $response, 1);

    expect($result->getStatusCode())
        ->toBe(200)
        ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
        ->and((string) $result->getBody())->toBe('{"id": 1, "official_name": "Updated Team"}');
});

test('delete team returns 204 on success', function () {
    $teamRepository = Mockery::mock(TeamRepository::class);

    $teamRepository->shouldReceive('delete')
        ->with(1)
        ->once()
        ->andReturn(true);

    $controller = new TeamController($teamRepository);
    $response = new Response();
    $result = $controller->delete($response, 1);

    expect($result->getStatusCode())->toBe(204);
});

test('delete team returns 404 if not found', function () {
    $teamRepository = Mockery::mock(TeamRepository::class);

    $teamRepository->shouldReceive('delete')
        ->with(1)
        ->once()
        ->andReturn(false);

    $controller = new TeamController($teamRepository);
    $response = new Response();
    $result = $controller->delete($response, 1);

    expect($result->getStatusCode())
        ->toBe(404)
        ->and($result->getHeaderLine('Content-Type'))->toBe('application/json')
        ->and((string) $result->getBody())->toBe('{"message":"Item not found"}');
});
