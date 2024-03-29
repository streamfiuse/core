<?php

declare(strict_types=1);

namespace App\DataDomain\Entities\Fiuselist;

use App\DataDomain\Entities\EntityInterface;

class FiuselistEntryEntity implements EntityInterface
{
    private int $contentId;
    private int $userId;
    private int $position;
    private string $likeStatus;
    private int $dislikeCount;
    private string $freeDate;
    private string $createdAt;
    private string $updatedAt;

    /**
     * FiuselistEntry constructor.
     */
    public function __construct(
        int $contentId,
        int $userId,
        int $position,
        string $likeStatus,
        int $dislikeCount,
        string $freeDate,
        string $createdAt,
        string $updatedAt
    ) {
        $this->contentId = $contentId;
        $this->userId = $userId;
        $this->position = $position;
        $this->likeStatus = $likeStatus; // no_interaction is the mysql enum the like_status col can be from
        $this->dislikeCount = $dislikeCount;
        $this->freeDate = $freeDate;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int
     */
    public function getContentId(): int
    {
        return $this->contentId;
    }


    public function setContentId(int $contentId): void
    {
        $this->contentId = $contentId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }


    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }


    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getLikeStatus(): string
    {
        return $this->likeStatus;
    }


    public function setLikeStatus(string $likeStatus): void
    {
        $this->likeStatus = $likeStatus;
    }

    /**
     * @return int
     */
    public function getDislikeCount(): int
    {
        return $this->dislikeCount;
    }


    public function setDislikeCount(int $dislikeCount): void
    {
        $this->dislikeCount = $dislikeCount;
    }

    /**
     * @return string
     */
    public function getFreeDate(): ?string
    {
        return $this->freeDate;
    }


    public function setFreeDate(string $freeDate): void
    {
        $this->freeDate = $freeDate;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt ?? '';
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt ?? '';
    }

    public function toArray(): array
    {
        return [
          'content_id' => $this->contentId,
          'user_id' => $this->userId,
          'position' => $this->position,
          'like_status' => $this->likeStatus,
          'dislike_count' => $this->dislikeCount,
          'free_date' => $this->freeDate,
          'created_at' => $this->createdAt,
          'updated_at' => $this->updatedAt,
        ];
    }
    /**
     *     private int $contentId;
    private int $userId;
    private int $position;
    private string $likeStatus;
    private int $dislikeCount;
    private string $freeDate;
    private string $createdAt;
    private string $updatedAt;
     */
}
