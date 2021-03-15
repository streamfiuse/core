<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface QueryRepositoryInterface
{
    public function create(array $attributes): array;
    public function find($id): Collection;
}
