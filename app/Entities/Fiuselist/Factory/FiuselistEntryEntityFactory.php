<?php

namespace App\Entities\Fiuselist\Factory;

use App\Entities\Fiuselist\FiuselistEntryEntity;

class FiuselistEntryEntityFactory
{
    public function create(
        array $fiuselistEntryData
    ): FiuselistEntryEntity
    {
        return new FiuselistEntryEntity(
            $fiuselistEntryData['content_id'],
            $fiuselistEntryData['user_id'],
            $fiuselistEntryData['position'],
            $fiuselistEntryData['like_status'],
            $fiuselistEntryData['dislike_count'],
            $fiuselistEntryData['free_date'],
            $fiuselistEntryData['created_at'],
            $fiuselistEntryData['updated_at'],
        );
    }
}
