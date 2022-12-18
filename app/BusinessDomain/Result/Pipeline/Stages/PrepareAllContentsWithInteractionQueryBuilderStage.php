<?php

declare(strict_types=1);

namespace App\BusinessDomain\Result\Pipeline\Stages;

use App\BusinessDomain\Result\Pipeline\Payload\ResultPayload;
use Illuminate\Support\Facades\DB;

class PrepareAllContentsWithInteractionQueryBuilderStage implements ResultPipelineStageInterface
{
    private const WITH_INTERACTION_LIKE_STATUS = ['liked', 'disliked'];
    public function __invoke(ResultPayload $payload): ResultPayload
    {
        $queryBuilder = DB::table('content')
            ->leftJoin('content_user', 'content.id', '=', 'content_user.content_id')
            ->select(['content.*', 'content_user.like_status'])
            ->union(
                DB::table('content')
                    ->leftJoin('content_user', 'content.id', '=', 'content_user.content_id')
                    ->where('content_user.user_id', '=', $payload->getUserId())
                    ->whereIn('content_user.like_status', self::WITH_INTERACTION_LIKE_STATUS)
                    ->select(['content.*', 'content_user.like_status'])
            );


        $payload->setQueryBuilder($queryBuilder);

        return $payload;
    }
}
