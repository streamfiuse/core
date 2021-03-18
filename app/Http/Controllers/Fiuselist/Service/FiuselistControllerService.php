<?php

namespace App\Http\Controllers\Fiuselist\Service;

use App\Entities\Fiuselist\Factory\FiuselistEntityFactory;
use App\Entities\Fiuselist\Factory\FiuselistEntryEntityFactory;
use App\Entities\Fiuselist\FiuselistEntity;
use App\Entities\Fiuselist\FiuselistEntryEntity;
use App\Repositories\Fiuselist\FiuselistRepository;
use Carbon\Carbon;

class FiuselistControllerService
{
    private FiuselistRepository $fiuselistRepository;
    private FiuselistEntityFactory $fiuselistEntityFactory;
    private FiuselistEntryEntityFactory $fiuselistEntryEntityFactory;

    public function __construct(
        FiuselistRepository $fiuselistRepository,
        FiuselistEntityFactory $fiuselistEntityFactory,
        FiuselistEntryEntityFactory $fiuselistEntryEntityFactory
    )
    {
        $this->fiuselistRepository = $fiuselistRepository;
        $this->fiuselistRepository->setTableName('content_user');

        $this->fiuselistEntityFactory = $fiuselistEntityFactory;
        $this->fiuselistEntryEntityFactory = $fiuselistEntryEntityFactory;
    }

    public function getFiuselistByUserId(int $userId): FiuselistEntity
    {
        $fiuselistData = $this->fiuselistRepository->find($userId, 'user_');
        return $this->fiuselistEntityFactory->create(json_decode(json_encode($fiuselistData), true));
    }

    public function insertNewEntryToFiuselist(FiuselistEntryEntity $fiuselistEntry, int $userId): FiuselistEntity
    {
        $fiuselist = $this->getFiuselistByUserId($userId);

        return $this->fiuselistEntityFactory->create([]);
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

    public function createFiuselistEntryFromAttributes(
        int $contentId,
        int $userId,
        ?int $position,
        string $likeStatus
    ): FiuselistEntryEntity
    {
        $todaysDate = Carbon::today();
        $fiuselistEntryData = [
            'content_id' => $contentId,
            'user_id' => $userId,
            'position' => $position,
            'like_status' => $likeStatus,
            'dislike_count' => $likeStatus === 'disliked' ? 1: 0,
            'free_date' => ($likeStatus === 'disliked' ? $todaysDate->addDays(30) : null),
            'created_at' => $todaysDate,
            'updated_at' => null
        ];

        return $this->fiuselistEntryEntityFactory->create($fiuselistEntryData);
    }
}
