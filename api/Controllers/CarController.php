<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\AbstractController;
use App\Repositories\CarRepository;

class CarController extends AbstractController
{
    public function __construct(CarRepository $carRepository)
    {
        parent::__construct($carRepository);
    }
}
