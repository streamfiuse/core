<?php

declare(strict_types=1);

namespace App\BusinessDomain\Result\Model;

use Illuminate\Support\Collection;

class ResultModel
{
    /**
     * @var ResultContentModel[] $contentModels
     */
    private array $contentModels;

    /**
     * @return ResultContentModel[]
     */
    public function getContentModels(): array
    {
        return $this->contentModels;
    }

    /**
     * @param ResultContentModel[] $contentModels
     */
    public function setContentModels(array $contentModels): void
    {
        $this->contentModels = $contentModels;
    }
}
