<?php

namespace App\BusinessDomain\Fiuselist\Rule;

use App\DataDomain\Entities\Fiuselist\FiuselistEntity;
use App\DataDomain\Entities\Fiuselist\FiuselistEntryEntity;

class IsFiuselistEntryAlreadyInFiuselistRule
{
    public function appliesTo(
        FiuselistEntity $fiuselist,
        FiuselistEntryEntity $newFiuselistEntry
    ): bool {
        $fiuselistEntries = $fiuselist->getFiuselistEntries();
        foreach ($fiuselistEntries as $fiuselistEntry) {
            if ($fiuselistEntry->getContentId() === $newFiuselistEntry->getContentId()) {
                return true;
            }
        }

        return false;
    }
}
