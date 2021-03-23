<?php

namespace App\Http\Controllers\Content\Service;

use App\Http\Resources\ContentResource;
use App\Models\Content;
use App\Traits\ProcessesJson;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContentControllerService
{
    use ProcessesJson;

    public function getContentsByIdentifiers(array $contentIdentifiersArray): array
    {
        $contents = [];
        $failToFetchContentCount = 0;
        foreach ($contentIdentifiersArray as $contentId){
            try {
                $content = Content::findOrFail($contentId);
                $contents[$contentId] = ['status' => 'success', 'content_data' => new ContentResource($content)];
            } catch (ModelNotFoundException $e) {
                $contents[$contentId] = ['status' => 'failed', 'message' => 'Could not find content with such an identifier'];
                $failToFetchContentCount++;
            }
        }
        return ['status' => $failToFetchContentCount > 0 ? 'failed' : 'success', 'contents' =>  $contents];
    }
}
