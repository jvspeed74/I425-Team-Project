<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\AbstractController;
use App\Repositories\TeamRepository;

class TeamController extends AbstractController
{
    public function __construct(TeamRepository $teamRepository)
    {
        parent::__construct($teamRepository);
    }
}
