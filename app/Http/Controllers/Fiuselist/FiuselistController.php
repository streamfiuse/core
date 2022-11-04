<?php

declare(strict_types=1);

namespace App\Http\Controllers\Fiuselist;

use App\BusinessDomain\Fiuselist\Rule\IsUsersContentInOneOfGivenLikeStatusRule;
use App\Http\Controllers\Controller;
use App\Http\Requests\Fiuselist\DislikeRequest;
use App\Http\Requests\Fiuselist\GetFiuselistRequest;
use App\Http\Requests\Fiuselist\LikeRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FiuselistController extends Controller
{
    private IsUsersContentInOneOfGivenLikeStatusRule $isUsersContentInOneOfGivenLikeStatusRule;

    public function __construct(
        IsUsersContentInOneOfGivenLikeStatusRule $isUsersContentInOneOfGivenLikeStatusRule
    ) {
        $this->isUsersContentInOneOfGivenLikeStatusRule = $isUsersContentInOneOfGivenLikeStatusRule;
    }

    public function getFiuselist(GetFiuselistRequest $request): JsonResponse
    {
        return new JsonResponse([
            'success' => true
        ]);
    }

    public function likeContent(LikeRequest $request): JsonResponse
    {
        $id = $request->validated()['id'];
        /** @var User $user */
        $user = Auth::user();

        if ($this->isUsersContentInOneOfGivenLikeStatusRule->appliesTo($user, $id, ['liked'])) {
            return new JsonResponse([
                'status' => 'failed',
                'message' => 'Already liked'
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($this->isUsersContentInOneOfGivenLikeStatusRule->appliesTo($user, $id, ['disliked', 'no_interaction'])) {
            $user->contents()->updateExistingPivot($id, ['like_status' => 'liked']);
        } else {
            // now one can be sure that the user did not interact with the content yet and attach the relation initially
            $user->contents()->attach($id, ['like_status' => 'liked']);
        }

        return new JsonResponse([
            'status' => 'success',
        ]);
    }

    public function dislikeContent(DislikeRequest $request): JsonResponse
    {
        $id = $request->validated()['id'];
        /** @var User $user */
        $user = Auth::user();

        if ($this->isUsersContentInOneOfGivenLikeStatusRule->appliesTo($user, $id, ['disliked'])) {
            return new JsonResponse([
                'status' => 'failed',
                'message' => 'Already disliked'
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($this->isUsersContentInOneOfGivenLikeStatusRule->appliesTo($user, $id, ['liked', 'no_interaction'])) {
            $newDislikeCount = ++$user->contents()
                ->where('content_id', '=', $id)
                ->first(['dislike_count'])
                ->dislike_count;

            $user->contents()->updateExistingPivot(
                $id,
                ['like_status' => 'disliked', 'dislike_count' => $newDislikeCount]
            );
        } else {
            // now one can be sure that the user did not interact with the content yet and attach the relation initially
            $user->contents()->attach($id, ['like_status' => 'disliked', 'dislike_count' => 1]);
        }

        return new JsonResponse([
            'status' => 'success',
        ]);
    }
}
