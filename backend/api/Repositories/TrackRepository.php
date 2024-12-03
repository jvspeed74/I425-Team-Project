<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\AbstractRepository;
use App\Models\Track;

class TrackRepository extends AbstractRepository
{
    /**
     * @param Track $model
     */
    public function __construct(Track $model)
    {
        parent::__construct($model);
    }
}
