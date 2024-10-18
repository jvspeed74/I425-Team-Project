<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Collection;

class DriverRepository
{
    protected Driver $model;

    /**
     * @param Driver $model
     */
    public function __construct(Driver $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection<int, Driver>
     */
    public function getAllDrivers(): Collection
    {
        return $this->model::all();  // Uses Eloquent's all() method on the injected model
    }

    /**
     * @param int $id
     * @return Driver|false
     */
    public function getDriverById(int $id): Driver | false
    {
        // Find the Driver by ID
        $driver = $this->model->query()->find($id);

        // Return false if the team is not found
        if (!$driver) {
            return false;
        }

        // Return the team if found
        return $driver;
    }


    /**
     * @param array<string, string> $data
     * @return Driver
     */
    public function createDriver(array $data): Driver
    {
        return $this->model->query()->create($data);
    }


    /**
     * @param int $id
     * @param array<string, string> $data
     * @return Driver|false
     */
    public function updateDriver(int $id, array $data): Driver | false
    {
        $driver = $this->model->query()->find($id);  // Find the driver by ID
        if (!$driver) {
            return false;  // Return false if the driver is not found
        }

        // Update the driver with the provided data
        if ($driver->update($data)) {
            return $driver;
        }

        return false;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteDriver(int $id): bool
    {
        $driver = $this->model->query()->find($id);  // Find the driver by ID
        if ($driver) {
            return (bool) $driver->delete();
        }
        return false;  // Return false if the driver is not found
    }
}
