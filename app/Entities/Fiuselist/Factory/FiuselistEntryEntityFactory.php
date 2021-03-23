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
            $fiuselistEntryData['position'] ?? -1,
            $fiuselistEntryData['like_status'] ?? 'no_interaction',
            $fiuselistEntryData['dislike_count'] ?? 0,
            $fiuselistEntryData['free_date'] ?? '',
            $fiuselistEntryData['created_at'] ?? '',
            $fiuselistEntryData['updated_at'] ?? '',
        );
    }
}
