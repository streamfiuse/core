<?php

namespace App\Http\Controllers\Fiuselist;

use App\BusinessDomain\Fiuselist\Rule\IsFiuselistEntryAlreadyInFiuselistRule;
use App\BusinessDomain\Fiuselist\Service\FiuselistControllerService;
use App\BusinessDomain\Fiuselist\Service\FiuselistEntityService;
use App\BusinessDomain\Fiuselist\Service\FiuselistEntryEntityService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Fiuselist\FiuselistAddContentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class FiuselistController extends Controller
{
    private FiuselistControllerService $fiuselistControllerService;
    private FiuselistEntityService $fiuselistEntityService;
    private FiuselistEntryEntityService $fiuselistEntryEntityService;
    private IsFiuselistEntryAlreadyInFiuselistRule $isFiuselistEntryAlreadyInFiuselistRule;

    public function __construct(
        FiuselistControllerService $fiuselistControllerService,
        FiuselistEntityService $fiuselistEntityService,
        FiuselistEntryEntityService $fiuselistEntryEntityService,
        IsFiuselistEntryAlreadyInFiuselistRule $isFiuselistEntryAlreadyInFiuselistRule
    ) {
        $this->fiuselistControllerService = $fiuselistControllerService;
        $this->fiuselistEntityService = $fiuselistEntityService;
        $this->fiuselistEntryEntityService = $fiuselistEntryEntityService;
        $this->isFiuselistEntryAlreadyInFiuselistRule = $isFiuselistEntryAlreadyInFiuselistRule;
    }

    public function getFiuselistOfCurrentlyLoggedInUser(): JsonResponse
    {
        $userId = Auth::user()->getAuthIdentifier();
        if (is_null($userId)) {
            return response()->json(['status' => 'failed', 'message' => 'Could not fetch user_id of authenticated user'], 500);
        }

        $fiuselist = $this->fiuselistControllerService->getFiuselistByUserId($userId);
        $fiuselistEntries = $this->fiuselistEntityService->fiuselistEntriesToAssocArray($fiuselist);

        if (!isset($fiuselistEntries[0])) {
            return response()->json(['status' => 'failed', 'message' => 'No entries for the currently logged in user found'], 404);
        }

        return response()->json(['status' => 'success', 'fiuselist' => $fiuselistEntries], 200);
    }

    public function addContentToFiuselistOfCurrentlyLoggedInUser(FiuselistAddContentRequest $request): JsonResponse
    {
        $this->validateRequest($request);

        //transform request params to a dedicated variable
        $input = $request->all();

        $userId = Auth::user()->getAuthIdentifier();
        $contentId = (int)$input['content_id'];
        $likeStatus = (string)$input['like_status'];
        $positionOnFiuselist = (int)(isset($input['position']) ? $input['position'] : null);

        $newFiuselistEntryEntity = $this->fiuselistEntryEntityService->createFiuselistEntryEntityFromAttributes($contentId, $userId, $positionOnFiuselist, $likeStatus);
        $oldFiuselistEntity = $this->fiuselistControllerService->getFiuselistByUserId($userId);

        if ($this->isFiuselistEntryAlreadyInFiuselistRule->appliesTo($oldFiuselistEntity, $newFiuselistEntryEntity)) {
            return response()->json(['status' => 'failed', 'message' => 'The entry is already on the fiuselist']);
        }
        $newFiuselistEntity = $this->fiuselistControllerService->insertNewEntryToFiuselist($newFiuselistEntryEntity, $oldFiuselistEntity);

        if ($newFiuselistEntity === null) {
            return response()->json(['status' => 'failed', 'message' => 'Failed writing the new entry to the database']);
        }

        return response()->json(['status' => 'success', 'newFiuselist' => $this->fiuselistEntityService->fiuselistEntriesToAssocArray($newFiuselistEntity)], 200);
    }
}
