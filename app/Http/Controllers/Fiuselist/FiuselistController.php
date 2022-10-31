<?php

declare(strict_types=1);

namespace App\Http\Controllers\Fiuselist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fiuselist\LikeRequest;
use Illuminate\Http\JsonResponse;

class FiuselistController extends Controller
{
    public function getFiuselist(): JsonResponse
    {
        return new JsonResponse([
            'success' => true
        ]);
    }

    public function likeContent(LikeRequest $request): JsonResponse
    {
        $id = $request->validated()['id'];

        return new JsonResponse([
            'success' => true,
            'id' => $id
        ]);
    }
}
