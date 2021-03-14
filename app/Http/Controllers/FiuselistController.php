<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;


class FiuselistController extends Controller
{
    public function getFiuselistOfCurrentlyLoggedInUser(): JsonResponse
    {
        return response()->json(['status' => 'success']);
    }
}
