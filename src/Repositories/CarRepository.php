<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Collection;

class CarRepository
{
    protected Car $model;

    /**
     * @param Car $model
     */
    public function __construct(Car $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getAllCars(): Collection
    {
        return $this->model::all();  // Uses Eloquent's all() method on the injected model
    }

    /**
     * @param int $id
     * @return Car|false
     */
    public function getCarById(int $id): Car | false
    {
        // Find the Driver by ID
        $car = $this->model->query()->find($id);

        // Return false if the team is not found
        if (!$car) {
            return false;
        }

        // Return the team if found
        return $car;
    }


    /**
     * @param array<string, string> $data
     * @return Car
     */
    public function createCar(array $data): Car
    {
        return $this->model->query()->create($data);
    }


    /**
     * @param int $id
     * @param array<string, string> $data
     * @return Car|false
     */
    public function updateCar(int $id, array $data): Car | false
    {
        $car = $this->model->query()->find($id);  // Find the driver by ID
        if (!$car) {
            return false;  // Return false if the driver is not found
        }

        // Update the driver with the provided data
        if ($car->update($data)) {
            return $car;
        }

        return false;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteCar(int $id): bool
    {
        $car = $this->model->query()->find($id);  // Find the driver by ID
        if ($car) {
            return (bool) $car->delete();
        }
        return false;  // Return false if the driver is not found
    }
}
