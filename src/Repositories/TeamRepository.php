<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamRepository
{
    protected Team $model;

    /**
     * @param Team $model
     */
    public function __construct(Team $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getAllTeams(): Collection
    {
        return $this->model::all();  // Uses Eloquent's all() method on the injected model
    }

    /**
     * @param int $id
     * @return Team|false
     */
    public function getTeamById(int $id): Team | false
    {
        // Find the team by ID
        $team = $this->model->query()->find($id);

        // Return false if the team is not found
        if (!$team) {
            return false;
        }

        // Return the team if found
        return $team;
    }


    /**
     * @param array<string, string> $data
     * @return Team
     */
    public function createTeam(array $data): Team
    {
        return $this->model->query()->create($data);
    }


    /**
     * @param int $id
     * @param array<string, string> $data
     * @return Team|false
     */
    public function updateTeam(int $id, array $data): Team | false
    {
        $team = $this->model->query()->find($id);  // Find the team by ID
        if (!$team) {
            return false;  // Return false if the team is not found
        }

        // Update the team with the provided data
        if ($team->update($data)) {
            return $team;
        }

        return false;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteTeam(int $id): bool
    {
        $team = $this->model->query()->find($id);  // Find the team by ID
        if ($team) {
            return (bool) $team->delete();
        }
        return false;  // Return false if the team is not found
    }
}
