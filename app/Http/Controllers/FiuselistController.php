<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Query\FiuselistQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class FiuselistController extends Controller
{
    private FiuselistQuery $fiuselistQuery;

    public function __construct(
        FiuselistQuery $fiuselistQuery
    )
    {
        $this->fiuselistQuery = $fiuselistQuery;
    }

    public function getFiuselistOfCurrentlyLoggedInUser(): JsonResponse
    {
        $userId = Auth::user()->getAuthIdentifier();
        if (is_null($userId)) {
           return response()->json(['status' => 'failed', 'message' => 'Could not fetch user_id of authenticated user'], 500);
        }

        $fiuselist = $this->fiuselistQuery->getFiuselistByUserId($userId)->get();
        if (is_null($fiuselist)) {
            return response()->json(['status' => 'failed', 'message' => 'No entries for the currently logged in user found'], 404);
        }

        return response()->json(['status' => 'success', 'fiuselist' => $fiuselist], 200);
    }
}
