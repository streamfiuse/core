<?php

declare(strict_types=1);

namespace App\DataDomain\Entities\Fiuselist;

use App\DataDomain\Entities\EntityInterface;

class FiuselistEntity implements EntityInterface
{
    /**
     * @var FiuselistEntryEntity[]
     */
    private array $fiuselistEntries;

    /**
     * FiuselistEntity constructor.
     */
    public function __construct(array $fiuselistEntries)
    {
        $this->fiuselistEntries = $fiuselistEntries;
    }

    /**
     * @return FiuselistEntryEntity[]
     */
    public function getFiuselistEntries(): array
    {
        return $this->fiuselistEntries;
    }

    public function setFiuselistEntries(array $fiuselistEntries): void
    {
        $this->fiuselistEntries = $fiuselistEntries;
    }

    public function toArray(): array
    {
        $fiuselistEntriesArray = [];
        foreach ($this->fiuselistEntries as $fiuselistEntry) {
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
