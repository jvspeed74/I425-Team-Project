<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements RepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model::all();
    }

    public function getById(int $id): Model|false
    {
        $record = $this->model::where('id', $id)->first();
        return $record ?? false;
    }

    public function create(array $data): Model
    {
        return $this->model::create($data);
    }

    public function update(int $id, array $data): Model|false
    {
        $record = $this->model::find($id);
        if ($record !== null && $record->update($data)) {
            return $record;
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $record = $this->model::find($id);
        return $record !== null && $record->delete() === true;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param string $sortBy
     * @param string $order
     * @return LengthAwarePaginator
     */
    public function getAllWithParams(
        int $page,
        int $limit,
        string $sortBy,
        string $order,
    ): LengthAwarePaginator {
        return $this->model::orderBy($sortBy, $order)
            ->paginate($limit, ['*'], 'page', $page);
    }

    /**
     * @param string $q
     * @return Collection<int, Model>
     */
    public function search(string $q): Collection
    {
        $terms = explode(' ', $q);
        $fillable = $this->model->getFillable();

        return $this->model::where(function (Builder $query) use ($terms, $fillable) {
            foreach ($terms as $term) {
                foreach ($fillable as $field) {
                    $query->orWhere($field, 'LIKE', "%$term%");
                }
            }
        })
            ->get();
    }

    public function findBy(string $field, mixed $value): Model|null
    {
        return $this->model::where($field, $value)->first();
    }
}
