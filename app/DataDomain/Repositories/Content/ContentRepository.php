<?php

declare(strict_types=1);

namespace App\DataDomain\Repositories\Content;

use App\DataDomain\Entities\Content\ContentEntity;
use App\DataDomain\Entities\Content\Factory\ContentEntityFactory;
use App\DataDomain\Repositories\EloquentBaseRepository;
use App\Models\Content;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Date;

class ContentRepository extends EloquentBaseRepository implements ContentRepositoryInterface
{
    private ContentEntityFactory $contentEntityFactory;

    public function __construct(ContentEntityFactory $contentEntityFactory)
    {
        parent::__construct(new Content());
        $this->contentEntityFactory = $contentEntityFactory;
    }

    /**
     * @param array $identifiersArray
     * @return ContentEntity[]
     */
    public function findMultiple(array $identifiersArray): array
    {
        $entities = [];
        $failToFetchCount = 0;
        foreach ($identifiersArray as $id) {
            try {
                $content = $this->buildContentEntity($this->model->findOrFail($id));
                $entities[$id] = $content;
            } catch (ModelNotFoundException $e) {
                $entities[$id] = null;
                $failToFetchCount++;
            }
        }
        return ['status' => $failToFetchCount> 0 ? 'failed' : 'success', 'entities' =>  $entities];
    }

    public function updateContent(Content $contentModel, array $requestParameters): ContentEntity
    {
        foreach ($requestParameters as $parameterKey => $parameterValue) {
            $contentModel->setAttribute($parameterKey, $parameterValue);
        }

        $contentModel->setAttribute('updated_at', Date::now());

        $contentModel->save();

        return $this->buildContentEntity($contentModel);
    }

    private function buildContentEntity(Content $conentModel): ContentEntity
    {
        $contentData = $conentModel->toArray();

        return $this->contentEntityFactory->create($contentData);
    }
}
