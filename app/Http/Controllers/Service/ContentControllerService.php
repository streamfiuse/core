<?php

namespace App\Http\Controllers\Service;

use App\Http\Resources\ContentResource;
use App\Models\Content;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ContentControllerService
{
    public function getIdentifiersArrayFromRequest(Request $request): array
    {
        $identifiersString = $this->getIdentifiersStringFromRequest($request);

        return json_decode($identifiersString);
    }

    public function getContentsByIdentifiers(array $contentIdentifiersArray): array
    {
        $contents = [];
        $failToFetchContentCount = 0;
        foreach ($contentIdentifiersArray as $contentId){
            try {
                $content = Content::findOrFail($contentId);
                $contents[$contentId] = new ContentResource($content);
            } catch (ModelNotFoundException $e) {
                $contents[$contentId] = 'Could not find content with such an identifier';
                $failToFetchContentCount++;
            }
        }
        return ['status' => $failToFetchContentCount > 0 ? 'failed' : 'success', 'contents' =>  $contents];
    }

    private function getIdentifiersStringFromRequest(Request $request): string
    {
        return $request->get('content_ids');
    }

}
