<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Service\Fiuselist\FiuselistService;
use Illuminate\Http\JsonResponse;
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
}
