<?php

namespace App\Infrastructure\Repositories;

use App\Exceptions\NotCreatedException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class QueryBaseRepository implements QueryRepositoryInterface
{
    protected string $tableName;

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     */
    public function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    public function __construct(string $tableName = '')
    {
        $this->tableName = $tableName;
    }

    public function create(array $attributes): array
    {
        if (DB::table($this->tableName)->insert($attributes) === true) {
            return $attributes;
        }

        throw new NotCreatedException('Database entry could not be created');
    }

    public function find($id, string $idPrefix = ''): Collection
    {
        return DB::table($this->tableName)
            ->where($idPrefix .'id', '=', $id)
            ->get();
    }
}
