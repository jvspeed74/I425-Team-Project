<?php

declare(strict_types=1);

namespace Repositories;

use App\Models\Team;
use App\Repositories\TeamRepository;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TeamRepository::class)]
#[UsesClass(TeamRepository::class)]
class TeamRepositoryTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetAllTeams(): void
    {
        // Create a mock of the Team model
        $teamMock = Mockery::mock(Team::class);

        // Create a mock collection to return
        $mockCollection = Mockery::mock(Collection::class);

        // Define the behavior of the all() method
        $teamMock->shouldReceive('all')
            ->once()
            ->andReturn($mockCollection);

        // Instantiate the repository with the mock
        $teamRepository = new TeamRepository($teamMock);

        // Call the method under test
        $result = $teamRepository->getAllTeams();

        // Assert that the result matches the mocked collection
        $this->assertSame($mockCollection, $result);
    }

    public function testGetTeamByIdReturnsTeam(): void
    {
        // Create a mock of the Team model
        $teamMock = Mockery::mock(Team::class);

        // Create a mock of the Team instance that will be returned
        $mockTeam = Mockery::mock(Team::class);

        // Define the behavior of the find() method
        $teamMock->shouldReceive('query->find')
            ->with(1)
            ->once()
            ->andReturn($mockTeam);

        // Instantiate the repository with the mock
        $teamRepository = new TeamRepository($teamMock);

        // Call the method under test
        $result = $teamRepository->getTeamById(1);

        // Assert that the result matches the mock team
        $this->assertSame($mockTeam, $result);
    }

    public function testGetTeamByIdReturnsFalseIfNotFound(): void
    {
        // Create a mock of the Team model
        $teamMock = Mockery::mock(Team::class);

        // Define the behavior of the find() method to return null
        $teamMock->shouldReceive('query->find')
            ->with(1)
            ->once()
            ->andReturn(null);

        // Instantiate the repository with the mock
        $teamRepository = new TeamRepository($teamMock);

        // Call the method under test
        $result = $teamRepository->getTeamById(1);

        // Assert that the result is false
        $this->assertFalse($result);
    }

    public function testCreateTeam(): void
    {
        // Create a mock of the Team model
        $teamMock = Mockery::mock(Team::class);

        // Create mock team data
        $mockData = [
            'official_name' => 'Team Test',
            'short_name' => 'TT',
            'headquarters' => 'Test City',
            'team_principal' => 'John Doe',
        ];

        // Create a mock of the created Team instance
        $mockTeam = Mockery::mock(Team::class);

        // Define the behavior of the create() method
        $teamMock->shouldReceive('query->create')
            ->with($mockData)
            ->once()
            ->andReturn($mockTeam);

        // Instantiate the repository with the mock
        $teamRepository = new TeamRepository($teamMock);

        // Call the method under test
        $result = $teamRepository->createTeam($mockData);

        // Assert that the result matches the mock team
        $this->assertSame($mockTeam, $result);
    }

    public function testUpdateTeam(): void
    {
        // Create a mock of the Team model
        $teamMock = Mockery::mock(Team::class);

        // Mock data for the update
        $mockData = [
            'official_name' => 'Updated Team',
        ];

        // Create a mock of the Team instance that will be returned
        $mockTeam = Mockery::mock(Team::class);

        // Define the behavior of the find() and update() methods
        $teamMock->shouldReceive('query->find')
            ->with(1)
            ->once()
            ->andReturn($mockTeam);

        $mockTeam->shouldReceive('update')
            ->with($mockData)
            ->once()
            ->andReturn(true);

        // Instantiate the repository with the mock
        $teamRepository = new TeamRepository($teamMock);

        // Call the method under test
        $result = $teamRepository->updateTeam(1, $mockData);

        // Assert that the result matches the mock team
        $this->assertSame($mockTeam, $result);
    }

    public function testDeleteTeam(): void
    {
        // Create a mock of the Team model
        $teamMock = Mockery::mock(Team::class);

        // Create a mock of the Team instance that will be deleted
        $mockTeam = Mockery::mock(Team::class);

        // Define the behavior of the find() and delete() methods
        $teamMock->shouldReceive('query->find')
            ->with(1)
            ->once()
            ->andReturn($mockTeam);

        $mockTeam->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        // Instantiate the repository with the mock
        $teamRepository = new TeamRepository($teamMock);

        // Call the method under test
        $result = $teamRepository->deleteTeam(1);

        // Assert that the result is true
        $this->assertTrue($result);
    }
}
