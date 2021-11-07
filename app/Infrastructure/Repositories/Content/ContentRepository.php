<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories\Content;

use App\Http\Resources\ContentResource;
use App\Infrastructure\Repositories\EloquentBaseRepository;
use App\Models\Content;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Date;

class ContentRepository extends EloquentBaseRepository implements ContentRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Content());
    }

    public function findMultiple(array $identifiersArray): array
    {
        $models = [];
        $failToFetchCount = 0;
        foreach ($identifiersArray as $id) {
            try {
                $content = $this->model->findOrFail($id);
                $models[$id] = ['status' => 'success', 'model' => new ContentResource($content)];
            } catch (ModelNotFoundException $e) {
                $models[$id] = ['status' => 'failed', 'message' => 'Could not find model with such an identifier'];
                $failToFetchCount++;
            }
        }
        return ['status' => $failToFetchCount > 0 ? 'failed' : 'success', 'models' =>  $models];
    }

    public function updateContent(Content $contentModel, array $requestParameters): Content
    {
        foreach ($requestParameters as $parameterKey => $parameterValue) {
            $contentModel->setAttribute($parameterKey, $parameterValue);
        }

        $contentModel->setAttribute('updated_at', Date::now());

        $contentModel->save();

        return $contentModel;
    }
}
