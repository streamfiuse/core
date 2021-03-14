<?php

namespace App\Http\Controllers\Service;

use App\Http\Resources\ContentResource;
use App\Models\Content;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContentControllerService
{
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

    public function isJson(string $string):bool
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
