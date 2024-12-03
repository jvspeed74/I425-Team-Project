<?php

declare(strict_types=1);

use App\Models\Team;
use App\Repositories\TeamRepository;
use Illuminate\Database\Eloquent\Collection;

covers(TeamRepository::class);

afterEach(function () {
    Mockery::close();
});

test('get all teams', function () {
    $teamMock = Mockery::mock(Team::class);
    $mockCollection = Mockery::mock(Collection::class);

    $teamMock->shouldReceive('all')
        ->once()
        ->andReturn($mockCollection);

    $teamRepository = new TeamRepository($teamMock);
    $result = $teamRepository->getAll();

    expect($result)->toBe($mockCollection);
});

test('get team by id returns team', function () {
    $teamMock = Mockery::mock(Team::class);
    $mockTeam = Mockery::mock(Team::class);

    $teamMock->shouldReceive('where')
        ->with('id', 1)
        ->once()
        ->andReturnSelf();
    $teamMock->shouldReceive('first')
        ->once()
        ->andReturn($mockTeam);

    $teamRepository = new TeamRepository($teamMock);
    $result = $teamRepository->getById(1);

    expect($result)->toBe($mockTeam);
});

test('get team by id returns false if not found', function () {
    $teamMock = Mockery::mock(Team::class);

    $teamMock->shouldReceive('where')
        ->with('id', 1)
        ->once()
        ->andReturnSelf();
    $teamMock->shouldReceive('first')
        ->once()
        ->andReturnNull();

    $teamRepository = new TeamRepository($teamMock);
    $result = $teamRepository->getById(1);

    expect($result)->toBeFalse();
});

test('create team', function () {
    $teamMock = Mockery::mock(Team::class);
    $mockData = [
        'official_name' => 'Team Test',
        'short_name' => 'TT',
        'headquarters' => 'Test City',
        'team_principal' => 'John Doe',
    ];
    $mockTeam = Mockery::mock(Team::class);

    $teamMock->shouldReceive('create')
        ->with($mockData)
        ->once()
        ->andReturn($mockTeam);

    $teamRepository = new TeamRepository($teamMock);
    $result = $teamRepository->create($mockData);

    expect($result)->toBe($mockTeam);
});

test('update team', function () {
    $teamMock = Mockery::mock(Team::class);
    $mockData = ['official_name' => 'Updated Team'];
    $mockTeam = Mockery::mock(Team::class);

    $teamMock->shouldReceive('find')
        ->with(1)
        ->once()
        ->andReturn($mockTeam);
    $mockTeam->shouldReceive('update')
        ->with($mockData)
        ->once()
        ->andReturn(true);

    $teamRepository = new TeamRepository($teamMock);
    $result = $teamRepository->update(1, $mockData);

    expect($result)->toBe($mockTeam);
});

test('delete team', function () {
    $teamMock = Mockery::mock(Team::class);
    $mockTeam = Mockery::mock(Team::class);

    $teamMock->shouldReceive('find')
        ->with(1)
        ->once()
        ->andReturn($mockTeam);
    $mockTeam->shouldReceive('delete')
        ->once()
        ->andReturn(true);

    $teamRepository = new TeamRepository($teamMock);
    $result = $teamRepository->delete(1);

    expect($result)->toBeTrue();
});
