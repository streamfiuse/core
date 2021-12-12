<?php

declare(strict_types=1);

namespace App\Infrastructure\Converters;

use App\DataDomain\Entities\EntityInterface;

class EntitiyToArrayConverter
{
    /**
     * @param EntityInterface[] $entities
     * @return array
     */
    public static function convertEntitiesToArray(array $entities): array
    {
        $array = [];
        foreach ($entities as $id => $entity) {
            if ($entity !== null) {
                $array[$id] = $entity->toArray();
            } else {
                $array[$id] = null;
            }
        }

        return $array;
    }
}
