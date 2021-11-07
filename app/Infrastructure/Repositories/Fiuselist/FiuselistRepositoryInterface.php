<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories\Fiuselist;

use App\DataDomain\Entities\Fiuselist\FiuselistEntryEntity;

interface FiuselistRepositoryInterface
{
    public function writeFiuselistEntryToDatabase(FiuselistEntryEntity $newFiuselistEntry): bool;
}
