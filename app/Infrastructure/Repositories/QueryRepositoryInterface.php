<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use Illuminate\Support\Collection;

interface QueryRepositoryInterface
{
    public function create(array $attributes): array;
    public function find($id): Collection;
}
