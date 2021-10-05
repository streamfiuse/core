<?php

namespace App\BusinessDomain\Fiuselist\Service;

use App\DataDomain\Entities\Fiuselist\FiuselistEntity;
use App\DataDomain\Entities\Fiuselist\FiuselistEntryEntity;

class FiuselistEntityService
{
    public function addEntryToFiuselist(
        FiuselistEntryEntity $fiuselistEntry,
        FiuselistEntity $fiuselist
    ): FiuselistEntity {
        $fiuselistEntries = $fiuselist->getFiuselistEntries();
        $fiuselistEntries[] = $fiuselistEntry;
        $fiuselist->setFiuselistEntries($fiuselistEntries);

        return $fiuselist;
    }

    public function fiuselistEntriesToAssocArray(FiuselistEntity $fiuselist): array
    {
        $fiuselistEntries = $fiuselist->getFiuselistEntries();
        $fiuselistEntriesArray = [];
        foreach ($fiuselistEntries as $fiuselistEntry) {
            $fiuselistEntryContentArray['content_id'] = $fiuselistEntry->getContentId();
            $fiuselistEntryContentArray['user_id'] = $fiuselistEntry->getUserId();
            $fiuselistEntryContentArray['position'] = $fiuselistEntry->getPosition();
            $fiuselistEntryContentArray['like_status'] = $fiuselistEntry->getLikeStatus();
            $fiuselistEntryContentArray['dislike_count'] = $fiuselistEntry->getDislikeCount();
            $fiuselistEntryContentArray['free_date'] = $fiuselistEntry->getFreeDate();
            $fiuselistEntryContentArray['created_at'] = $fiuselistEntry->getCreatedAt();
            $fiuselistEntryContentArray['updated_at'] = $fiuselistEntry->getUpdatedAt();
            $fiuselistEntriesArray[] = $fiuselistEntryContentArray;
            unset($fiuselistEntryContentArray);
        }

        return $fiuselistEntriesArray;
    }
}
