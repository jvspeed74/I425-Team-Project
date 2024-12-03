<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\AbstractRepository;
use App\Models\Team;

class TeamRepository extends AbstractRepository
{
    /**
     * @param Team $model
     */
    public function __construct(Team $model)
    {
        parent::__construct($model);
    }
}
