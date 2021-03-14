<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Service\FiuselistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class FiuselistController extends Controller
{
    private FiuselistService $fiuselistService;

    public function __construct(FiuselistService $fiuselistService)
    {
        $this->fiuselistService = $fiuselistService;
    }

    public function getFiuselistOfCurrentlyLoggedInUser(): JsonResponse
    {
        $userId = Auth::user()->getAuthIdentifier();
        $users = \App\Models\ContentUsers::where(['user_id' => $userId])->where(['like_status' => 'liked'])->get(['content_id']);
        echo $users;

        return response()->json(['status' => $userId]);
    }
}
