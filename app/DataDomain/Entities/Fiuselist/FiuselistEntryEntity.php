<?php

namespace App\DataDomain\Entities\Fiuselist;

class FiuselistEntryEntity
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
     * @param int $contentId
     * @param int $userId
     * @param int $position
     * @param string $likeStatus
     * @param int $dislikeCount
     * @param string $freeDate
     * @param string $createdAt
     * @param string $updatedAt
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

    /**
     * @param int $contentId
     */
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

    /**
     * @param int $userId
     */
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

    /**
     * @param int $position
     */
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

    /**
     * @param string $likeStatus
     */
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

    /**
     * @param int $dislikeCount
     */
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

    /**
     * @param string $freeDate
     */
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

    /**
     * @param string|null $createdAt
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @param string|null $updatedAt
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
