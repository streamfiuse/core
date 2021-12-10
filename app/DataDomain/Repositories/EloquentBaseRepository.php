<?php

declare(strict_types=1);

namespace App\DataDomain\Repositories;

use http\Exception\RuntimeException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class EloquentBaseRepository implements EloquentRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function find($id): ?Model
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return null;
        }
    }

    public function findAll(): Collection
    {
        return $this->model->all();
    }

    public function delete(int $id): bool
    {
        $model = $this->model->findOrFail($id);
        $deleted = $model->delete();
        if ($deleted === null) {
            throw new RuntimeException();
        }
        return $deleted;
    }
}
