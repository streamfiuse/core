<?php

namespace App\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface EloquentRepositoryInterface
{

    public function create(array $attributes): Model;

    public function find($id): ?Model;
}
