<?php

declare(strict_types=1);

namespace App\DataDomain\Repositories\Content;

use App\DataDomain\Entities\Content\ContentEntity;
use App\Models\Content;

interface ContentRepositoryInterface
{
    /**
     * @param array $identifiersArray
     * @return ContentEntity[]
     */
    public function findMultiple(array $identifiersArray): array;

    public function updateContent(Content $contentModel, array $requestParameters): ContentEntity;
}
