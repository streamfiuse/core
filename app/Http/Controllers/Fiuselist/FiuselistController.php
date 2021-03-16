<?php

namespace App\Http\Controllers\Fiuselist;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Fiuselist\Service\FiuselistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FiuselistController extends Controller
{
    private FiuselistService $fiuselistService;

    public function __construct(
        FiuselistService $fiuselistService
    )
    {
        $this->fiuselistService = $fiuselistService;
    }

    public function getFiuselistOfCurrentlyLoggedInUser(): JsonResponse
    {
        $userId = Auth::user()->getAuthIdentifier();
        if (is_null($userId)) {
           return response()->json(['status' => 'failed', 'message' => 'Could not fetch user_id of authenticated user'], 500);
        }

        $fiuselist = $this->fiuselistService->getFiuselistByUserId($userId);
        $fiuselistEntries = $this->fiuselistService->fiuselistEntriesToAssocArray($fiuselist);

        if (!isset($fiuselistEntries[0])) {
            return response()->json(['status' => 'failed', 'message' => 'No entries for the currently logged in user found'], 404);
        }

        return response()->json(['status' => 'success', 'fiuselist' => $fiuselistEntries], 200);
    }

    public function addContentToFiuselistOfCurrentlyLoggedInUser(Request $request): JsonResponse
    {
        $requestParams = $request->all();

        return response()->json(['status' => 'success', 'requestParams' => $request->all(),]);


        /**
        $userId = Auth::user()->getAuthIdentifier();
        if (is_null($userId)) {
            return response()->json(['status' => 'failed', 'message' => 'Could not fetch user_id of authenticated user'], 500);
        }

        $fiuselist = $this->fiuselistService->getFiuselistByUserId($userId);
        $fiuselistEntries = $this->fiuselistService->fiuselistEntriesToAssocArray($fiuselist);

        if (!isset($fiuselistEntries[0])) {
            return response()->json(['status' => 'failed', 'message' => 'No entries for the currently logged in user found'], 404);
        }

        return response()->json(['status' => 'success', 'fiuselist' => $fiuselistEntries], 200);
         */
    }
}
