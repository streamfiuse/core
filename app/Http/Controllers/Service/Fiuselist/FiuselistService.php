<?php

namespace App\Http\Controllers\Service\Fiuselist;

use App\Entities\Fiuselist\Factory\FiuselistEntityFactory;
use App\Entities\Fiuselist\FiuselistEntity;
use App\Repositories\Fiuselist\FiuselistRepository;

class FiuselistService
{
    private FiuselistRepository $fiuselistRepository;
    private FiuselistEntityFactory $fiuselistEntityFactory;

    public function __construct(
        FiuselistRepository $fiuselistRepository,
        FiuselistEntityFactory $fiuselistEntityFactory
    )
    {
        $this->fiuselistRepository = $fiuselistRepository;
        $this->fiuselistRepository->setTableName('content_user');

        $this->fiuselistEntityFactory = $fiuselistEntityFactory;
    }

    public function getFiuselistByUserId(int $userId): FiuselistEntity
    {
        $fiuselistData = $this->fiuselistRepository->find($userId, 'user_');
        return $this->fiuselistEntityFactory->create($fiuselistData);
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
