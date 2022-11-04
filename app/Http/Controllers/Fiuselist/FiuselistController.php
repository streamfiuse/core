<?php

declare(strict_types=1);

namespace App\Http\Controllers\Fiuselist;

use App\BusinessDomain\Fiuselist\Rule\DoesUserAlreadyDislikeOrNotInteractWithContentRule;
use App\BusinessDomain\Fiuselist\Rule\DoesUserAlreadyLikeContentRule;
use App\Http\Controllers\Controller;
use App\Http\Requests\Fiuselist\GetFiuselistRequest;
use App\Http\Requests\Fiuselist\LikeRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FiuselistController extends Controller
{
    private DoesUserAlreadyLikeContentRule $doesUserAlreadyLikeContentRule;

    private DoesUserAlreadyDislikeOrNotInteractWithContentRule $dislikeOrNotInteractWithContentRule;

    public function __construct(
        DoesUserAlreadyLikeContentRule $doesUserAlreadyLikeContentRule,
        DoesUserAlreadyDislikeOrNotInteractWithContentRule $dislikeOrNotInteractWithContentRule
    ){
        $this->doesUserAlreadyLikeContentRule = $doesUserAlreadyLikeContentRule;
        $this->dislikeOrNotInteractWithContentRule = $dislikeOrNotInteractWithContentRule;
    }


    public function getFiuselist(GetFiuselistRequest $request): JsonResponse
    {
        return new JsonResponse([
            'success' => true
        ]);
    }

    public function likeContent(LikeRequest $request): JsonResponse
    {
        // TODO: refactor if conditions to dedicated rules
        // TODO: tests for like content endpoint and rules
        $id = $request->validated()['id'];
        /** @var User $user */
        $user = Auth::user();

        if ($this->doesUserAlreadyLikeContentRule->appliesTo($user, $id)) {
            return new JsonResponse([
                'status' => 'failed',
                'message' => 'Already liked'
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($this->dislikeOrNotInteractWithContentRule->appliesTo($user, $id)) {
            $user->contents()->updateExistingPivot($id, ['like_status' => 'liked']);
        } else {
            // now one can be sure that the user did not interact with the content yet and attach the relation initially
            $user->contents()->attach($id, ['like_status' => 'liked']);
        }

        return new JsonResponse([
            'status' => 'success',
        ]);
    }
}
