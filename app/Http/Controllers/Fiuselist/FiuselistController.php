<?php

declare(strict_types=1);

namespace App\Http\Controllers\Fiuselist;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class FiuselistController extends Controller
{
    public function getFiuselist(): JsonResponse
    {
        return new JsonResponse(['success' => true]);
    }
}
