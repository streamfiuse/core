<?php

namespace App\Http\Controllers\Fiuselist;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Fiuselist\Service\FiuselistControllerService;
use App\Http\Requests\Fiuselist\FiuselistAddContentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class FiuselistController extends Controller
{
    private FiuselistControllerService $fiuselistControllerService;

    public function __construct(
        FiuselistControllerService $fiuselistControllerService
    )
    {
        $this->fiuselistControllerService = $fiuselistControllerService;
    }

    public function getFiuselistOfCurrentlyLoggedInUser(): JsonResponse
    {
        $userId = Auth::user()->getAuthIdentifier();
        if (is_null($userId)) {
            return response()->json(['status' => 'failed', 'message' => 'Could not fetch user_id of authenticated user'], 500);
        }

        $fiuselist = $this->fiuselistControllerService->getFiuselistByUserId($userId);
        $fiuselistEntries = $this->fiuselistControllerService->fiuselistEntriesToAssocArray($fiuselist);

        if (!isset($fiuselistEntries[0])) {
            return response()->json(['status' => 'failed', 'message' => 'No entries for the currently logged in user found'], 404);
        }

        return response()->json(['status' => 'success', 'fiuselist' => $fiuselistEntries], 200);
    }

    public function addContentToFiuselistOfCurrentlyLoggedInUser(FiuselistAddContentRequest $request): JsonResponse
    {
        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed', 'message' => 'Invalid input', 'messages' => $validator->errors()], 422);
        }

        $input = $request->all();

        $userId = Auth::user()->getAuthIdentifier();
        $contentId = (int)$input['content_id'];
        $likeStatus = (string)$input['like_status'];
        $positionOnFiuselist = (int)(isset($input['position']) ? $input['position'] : null);

        $fiuselistEntry = $this->fiuselistControllerService->createFiuselistEntryFromAttributes($contentId, $userId, $positionOnFiuselist, $likeStatus);
        $newFiuselist = $this->fiuselistControllerService->insertNewEntryToFiuselist($fiuselistEntry, $userId);


        return response()->json(['status' => 'success', 'requestParams' => $request->all()], 200);


        /**
         * $userId = Auth::user()->getAuthIdentifier();
         * if (is_null($userId)) {
         * return response()->json(['status' => 'failed', 'message' => 'Could not fetch user_id of authenticated user'], 500);
         * }
         *
         * $fiuselist = $this->fiuselistService->getFiuselistByUserId($userId);
         * $fiuselistEntries = $this->fiuselistService->fiuselistEntriesToAssocArray($fiuselist);
         *
         * if (!isset($fiuselistEntries[0])) {
         * return response()->json(['status' => 'failed', 'message' => 'No entries for the currently logged in user found'], 404);
         * }
         *
         * return response()->json(['status' => 'success', 'fiuselist' => $fiuselistEntries], 200);
         */
    }
}
