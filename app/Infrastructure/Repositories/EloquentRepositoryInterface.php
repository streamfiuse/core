<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    public function create(array $attributes): Model;

    public function find($id): ?Model;

    public function findAll(): Collection;

    public function delete(int $id): bool;
}
