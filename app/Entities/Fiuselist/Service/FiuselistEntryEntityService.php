<?php

namespace App\Entities\Fiuselist\Service;

use App\Entities\Fiuselist\Factory\FiuselistEntryEntityFactory;
use App\Entities\Fiuselist\FiuselistEntryEntity;
use Carbon\Carbon;

class FiuselistEntryEntityService
{
    private FiuselistEntryEntityFactory $fiuselistEntryEntityFactory;

    public function __construct(
        FiuselistEntryEntityFactory $fiuselistEntryEntityFactory
    )
    {
        $this->fiuselistEntryEntityFactory = $fiuselistEntryEntityFactory;
    }

    public function createFiuselistEntryEntityFromAttributes(
        int $contentId,
        int $userId,
        ?int $position,
        string $likeStatus
    ): FiuselistEntryEntity
    {
        $createdAtDate = Carbon::today();
        $freeDate = Carbon::today()->addDays(30);

        $fiuselistEntryData = [
            'content_id' => $contentId,
            'user_id' => $userId,
            'position' => $position,
            'like_status' => $likeStatus,
            'dislike_count' => $likeStatus === 'disliked' ? 1: 0,
            'free_date' => $likeStatus === 'disliked' ? $freeDate->toISOString() : null,
            'created_at' => $createdAtDate->toISOString(),
            'updated_at' => ''
        ];

        return $this->fiuselistEntryEntityFactory->create($fiuselistEntryData);
    }

    public function extractAttributesArrayFromFiuselistEntryEntity(FiuselistEntryEntity $fiuselistEntryEntity): array
    {
        $attributesArray = [
            'content_id' => $fiuselistEntryEntity->getContentId(),
            'user_id' => $fiuselistEntryEntity->getUserId(),
            'position' => $fiuselistEntryEntity->getPosition(),
            'like_status' => $fiuselistEntryEntity->getLikeStatus(),
            'dislike_count' => $fiuselistEntryEntity->getDislikeCount(),
            'free_date' => $fiuselistEntryEntity->getFreeDate(),
            'created_at' => $fiuselistEntryEntity->getCreatedAt(),
        ];

        if (!empty($fiuselistEntryEntity->getUpdatedAt())) {
            $attributesArray['updated_at'] = $fiuselistEntryEntity->getUpdatedAt();
        }

        return $attributesArray;
    }
}
