<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;


class FiuselistController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['status' => 'success']);
    }
}
