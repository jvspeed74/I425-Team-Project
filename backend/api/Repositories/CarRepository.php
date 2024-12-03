<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\AbstractRepository;
use App\Models\Car;

class CarRepository extends AbstractRepository
{
    public function __construct(Car $model)
    {
        parent::__construct($model);
    }
}
