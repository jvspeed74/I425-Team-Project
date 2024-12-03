<?php

declare(strict_types=1);

namespace Unit\Repositories;

use App\Contracts\AbstractRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;

covers(AbstractRepository::class);

beforeEach(function () {
    $this->model = Mockery::mock(Model::class);
    $this->repository = new class ($this->model) extends AbstractRepository {
        public function __construct(Model $model)
        {
            parent::__construct($model);
        }
    };
    $this->collection = Mockery::mock(Collection::class);
});

afterEach(function () {
    Mockery::close();
});

describe('getAll', function () {
    it('returns a collection of models', function () {
        $this->model
            ->shouldReceive('all')
            ->once()
            ->andReturn($this->collection);

        $result = $this->repository->getAll();

        expect($result)->toBe($this->collection);
    });
});

describe('getById', function () {
    it('returns a model by id', function () {
        $this->model
            ->shouldReceive('where')
            ->with('id', 1)
            ->once()
            ->andReturn($this->model);

        $this->model
            ->shouldReceive('first')
            ->once()
            ->andReturn($this->model);

        $result = $this->repository->getById(1);

        expect($result)->toBe($this->model);
    });

    it('returns false if model is not found', function () {
        $this->model
            ->shouldReceive('where')
            ->with('id', 1)
            ->once()
            ->andReturn($this->model);

        $this->model
            ->shouldReceive('first')
            ->once()
            ->andReturn(null);

        $result = $this->repository->getById(1);

        expect($result)->toBeFalse();
    });
});

describe('create', function () {
    it('creates a model', function () {
        $data = ['make' => 'Toyota', 'model' => 'Corolla'];

        $this->model
            ->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturn($this->model);

        $result = $this->repository->create($data);

        expect($result)->toBe($this->model);
    });
});

describe('update', function () {
    it('updates a model', function () {
        $this->model
            ->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturn($this->model);

        $this->model
            ->shouldReceive('update')
            ->with(['make' => 'Toyota', 'model' => 'Corolla'])
            ->once()
            ->andReturnTrue();

        $result = $this->repository->update(
            1,
            ['make' => 'Toyota', 'model' => 'Corolla'],
        );

        expect($result)->toBe($this->model);
    });

    it('returns false if model is not found', function () {
        $this->model
            ->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturn(null);

        $result = $this->repository->update(
            1,
            ['make' => 'Toyota', 'model' => 'Corolla'],
        );

        expect($result)->toBeFalse();
    });
});

describe('delete', function () {
    it('deletes a model', function () {
        $this->model
            ->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturn($this->model);

        $this->model
            ->shouldReceive('delete')
            ->once()
            ->andReturnTrue();

        $result = $this->repository->delete(1);

        expect($result)->toBeTrue();
    });

    it('returns false if model is not found', function () {
        $this->model
            ->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturn(null);

        $result = $this->repository->delete(1);

        expect($result)->toBeFalse();
    });
});

describe('getAllWithParams', function () {
    it('returns a paginated collection of models', function () {
        $this->model
            ->shouldReceive('orderBy')
            ->with('make', 'asc')
            ->once()
            ->andReturn($this->model);

        $mockPaginator = Mockery::mock(LengthAwarePaginator::class);

        $this->model
            ->shouldReceive('paginate')
            ->with(10, ['*'], 'page', 1)
            ->once()
            ->andReturn($mockPaginator);

        $result = $this->repository->getAllWithParams(1, 10, 'make', 'asc');

        expect($result)->toBe($mockPaginator);
    });
});

describe('search', function () {
    it('returns a collection of models', function () {
        $this->model
            ->shouldReceive('getFillable')
            ->once()
            ->andReturn(['make', 'model']);

        $this->model
            ->shouldReceive('where')
            ->withArgs(function ($closure) {
                return is_callable($closure);
            })
            ->once()
            ->andReturn($this->model);

        $this->model
            ->shouldReceive('get')
            ->once()
            ->andReturn($this->collection);

        $result = $this->repository->search('test Toyota');

        expect($result)->toBe($this->collection);
    });
});
