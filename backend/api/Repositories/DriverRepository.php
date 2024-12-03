<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\AbstractRepository;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class DriverRepository extends AbstractRepository
{
    /**
     * @param Driver $model
     */
    public function __construct(Driver $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $q
     * @return Collection<int, Model>
     */
    public function search(string $q): Collection
    {
        $terms = explode(' ', $q);
        return $this->model::where(function (Builder $query) use ($terms) {
            foreach ($terms as $term) {
                $query->orWhere('first_name', 'LIKE', "%$term%")
                      ->orWhere('last_name', 'LIKE', "%$term%");
            }
        })->get();
    }
}
