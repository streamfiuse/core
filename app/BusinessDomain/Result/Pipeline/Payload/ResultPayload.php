<?php

declare(strict_types=1);

namespace App\BusinessDomain\Result\Pipeline\Payload;

use App\BusinessDomain\Result\Model\ResultModel;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use stdClass;

class ResultPayload
{
    private int $userId;

    /**
     * @var Collection<stdClass>
     */
    private Collection $queryData;

    private ?ResultModel $resultModel;

    private ?Builder $queryBuilder;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }


    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getResultModel(): ?ResultModel
    {
        return $this->resultModel;
    }

    public function setResultModel(?ResultModel $resultModel): void
    {
        $this->resultModel = $resultModel;
    }

    public function getQueryBuilder(): ?Builder
    {
        return $this->queryBuilder;
    }

    public function setQueryBuilder(?Builder $queryBuilder): void
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @return Collection<stdClass>
     */
    public function getQueryData(): Collection
    {
        return $this->queryData;
    }

    /**
     * @param Collection<stdClass> $queryData
     */
    public function setQueryData(Collection $queryData): void
    {
        $this->queryData = $queryData;
    }
}
