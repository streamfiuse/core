<?php

declare(strict_types=1);

namespace App\DataDomain\Repositories\Content;

use App\Models\Content;

interface ContentRepositoryInterface
{
    public function findMultiple(array $identifiersArray): array;

    public function updateContent(Content $contentModel, array $requestParameters): Content;
}
