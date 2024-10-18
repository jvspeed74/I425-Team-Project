<?php

declare(strict_types=1);

namespace Controllers;

use App\Controllers\TeamController;
use App\Models\Team;
use App\Repositories\TeamRepository;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

#[CoversClass(TeamController::class)]
#[UsesClass(TeamController::class)]
class TeamControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetAllTeams(): void
    {
        // Mock the TeamRepository
        $teamRepository = Mockery::mock(TeamRepository::class);

        // Mock a collection of teams
        $mockTeams = Mockery::mock(Collection::class);
        $mockTeams->shouldReceive('toJson')->andReturn('[]');

        // Define the behavior of getAllTeams
        $teamRepository->shouldReceive('getAllTeams')
            ->once()
            ->andReturn($mockTeams);

        // Create the controller
        $controller = new TeamController($teamRepository);

        // Mock the request and response
        $request = Mockery::mock(ServerRequestInterface::class);
        $response = new Response();

        // Call the controller method
        $result = $controller->getAllTeams($request, $response);

        // Assert that the response is JSON and the status is 200
        $this->assertSame(200, $result->getStatusCode());
        $this->assertSame('application/json', $result->getHeaderLine('Content-Type'));
        $this->assertSame('[]', (string) $result->getBody());
    }

    public function testGetTeamByIdReturnsTeam(): void
    {
        // Mock the TeamRepository
        $teamRepository = Mockery::mock(TeamRepository::class);

        // Mock a single team
        $mockTeam = Mockery::mock(Team::class);
        $mockTeam->shouldReceive('toJson')->andReturn('{"id": 1, "official_name": "Team A"}');

        // Define the behavior of getTeamById
        $teamRepository->shouldReceive('getTeamById')
            ->with(1)
            ->once()
            ->andReturn($mockTeam);

        // Create the controller
        $controller = new TeamController($teamRepository);

        // Mock the request and response
        $request = Mockery::mock(ServerRequestInterface::class);
        $response = new Response();

        // Mock the request arguments
        $args = ['id' => 1];

        // Call the controller method
        $result = $controller->getTeamById($request, $response, $args);

        // Assert that the response is JSON and the status is 200
        $this->assertSame(200, $result->getStatusCode());
        $this->assertSame('application/json', $result->getHeaderLine('Content-Type'));
        $this->assertSame('{"id": 1, "official_name": "Team A"}', (string) $result->getBody());
    }

    public function testGetTeamByIdReturns404IfNotFound(): void
    {
        // Mock the TeamRepository
        $teamRepository = Mockery::mock(TeamRepository::class);

        // Define the behavior of getTeamById to return false
        $teamRepository->shouldReceive('getTeamById')
            ->with(1)
            ->once()
            ->andReturn(false);

        // Create the controller
        $controller = new TeamController($teamRepository);

        // Mock the request and response
        $request = Mockery::mock(ServerRequestInterface::class);
        $response = new Response();

        // Mock the request arguments
        $args = ['id' => 1];

        // Call the controller method
        $result = $controller->getTeamById($request, $response, $args);

        // Assert that the response is JSON, the status is 404, and the correct message is returned
        $this->assertSame(404, $result->getStatusCode());
        $this->assertSame('application/json', $result->getHeaderLine('Content-Type'));
        $this->assertSame('{"message":"Team not found"}', (string) $result->getBody());
    }

    public function testCreateTeam(): void
    {
        // Mock the TeamRepository
        $teamRepository = Mockery::mock(TeamRepository::class);

        // Mock a new team
        $mockTeam = Mockery::mock(Team::class);
        $mockTeam->shouldReceive('toJson')->andReturn('{"id": 1, "official_name": "Team A"}');

        // Define the behavior of createTeam
        $teamRepository->shouldReceive('createTeam')
            ->once()
            ->andReturn($mockTeam);

        // Create the controller
        $controller = new TeamController($teamRepository);

        // Mock the request and response
        $request = Mockery::mock(ServerRequestInterface::class);
        $response = new Response();

        // Mock the request body
        $request->shouldReceive('getParsedBody')
            ->once()
            ->andReturn(['official_name' => 'Team A']);

        // Call the controller method
        $result = $controller->createTeam($request, $response);

        // Assert that the response is JSON, the status is 201, and the correct team is returned
        $this->assertSame(201, $result->getStatusCode());
        $this->assertSame('application/json', $result->getHeaderLine('Content-Type'));
        $this->assertSame('{"id": 1, "official_name": "Team A"}', (string) $result->getBody());
    }

    public function testUpdateTeamReturnsUpdatedTeam(): void
    {
        // Mock the TeamRepository
        $teamRepository = Mockery::mock(TeamRepository::class);

        // Mock an updated team
        $mockTeam = Mockery::mock(Team::class);
        $mockTeam->shouldReceive('toJson')->andReturn('{"id": 1, "official_name": "Updated Team"}');

        // Define the behavior of updateTeam
        $teamRepository->shouldReceive('updateTeam')
            ->with(1, ['official_name' => 'Updated Team'])
            ->once()
            ->andReturn($mockTeam);

        // Create the controller
        $controller = new TeamController($teamRepository);

        // Mock the request and response
        $request = Mockery::mock(ServerRequestInterface::class);
        $response = new Response();

        // Mock the request body
        $request->shouldReceive('getParsedBody')
            ->once()
            ->andReturn(['official_name' => 'Updated Team']);

        // Mock the request arguments
        $args = ['id' => 1];

        // Call the controller method
        $result = $controller->updateTeam($request, $response, $args);

        // Assert that the response is JSON, the status is 200, and the updated team is returned
        $this->assertSame(200, $result->getStatusCode());
        $this->assertSame('application/json', $result->getHeaderLine('Content-Type'));
        $this->assertSame('{"id": 1, "official_name": "Updated Team"}', (string) $result->getBody());
    }

    public function testDeleteTeamReturns204OnSuccess(): void
    {
        // Mock the TeamRepository
        $teamRepository = Mockery::mock(TeamRepository::class);

        // Define the behavior of deleteTeam to return true
        $teamRepository->shouldReceive('deleteTeam')
            ->with(1)
            ->once()
            ->andReturn(true);

        // Create the controller
        $controller = new TeamController($teamRepository);

        // Mock the request and response
        $request = Mockery::mock(ServerRequestInterface::class);
        $response = new Response();

        // Mock the request arguments
        $args = ['id' => 1];

        // Call the controller method
        $result = $controller->deleteTeam($request, $response, $args);

        // Assert that the response status is 204 (No Content)
        $this->assertSame(204, $result->getStatusCode());
    }

    public function testDeleteTeamReturns404IfNotFound(): void
    {
        // Mock the TeamRepository
        $teamRepository = Mockery::mock(TeamRepository::class);

        // Define the behavior of deleteTeam to return false
        $teamRepository->shouldReceive('deleteTeam')
            ->with(1)
            ->once()
            ->andReturn(false);

        // Create the controller
        $controller = new TeamController($teamRepository);

        // Mock the request and response
        $request = Mockery::mock(ServerRequestInterface::class);
        $response = new Response();

        // Mock the request arguments
        $args = ['id' => 1];

        // Call the controller method
        $result = $controller->deleteTeam($request, $response, $args);

        // Assert that the response is JSON, the status is 404, and the correct message is returned
        $this->assertSame(404, $result->getStatusCode());
        $this->assertSame('application/json', $result->getHeaderLine('Content-Type'));
        $this->assertSame('{"message":"Team not found"}', (string) $result->getBody());
    }
}
