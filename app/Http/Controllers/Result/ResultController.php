<?php

declare(strict_types=1);

namespace App\Http\Controllers\Result;

use App\BusinessDomain\Result\Pipeline\Payload\ResultPayload;
use App\BusinessDomain\Result\Pipeline\Stages\GetDataFromQueryBuilderStage;
use App\BusinessDomain\Result\Pipeline\Stages\PrepareAllContentsWithInteractionQueryBuilderStage;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use League\Pipeline\Pipeline;

class ResultController extends Controller
{
    public function getResult(): JsonResponse
    {
        $userId = Auth::id();

        $resultPayload = new ResultPayload($userId);

        $resultPipeline = (new Pipeline())
            ->pipe(new PrepareAllContentsWithInteractionQueryBuilderStage())
            ->pipe(new GetDataFromQueryBuilderStage());

        $resultPipeline->process($resultPayload);

        return new JsonResponse([
            'status' => 'success',
            'data' => $resultPayload->getQueryData()->toArray(),
        ]);
    }
}
