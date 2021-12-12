<?php

declare(strict_types=1);

namespace App\DataDomain\Entities;

interface EntityInterface
{
    public function toArray(): array;
}
