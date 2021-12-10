<?php

declare(strict_types=1);

namespace App\DataDomain\Repositories;

use Illuminate\Support\Collection;

interface QueryRepositoryInterface
{
    public function create(array $attributes): array;
    public function find($id): Collection;
}
