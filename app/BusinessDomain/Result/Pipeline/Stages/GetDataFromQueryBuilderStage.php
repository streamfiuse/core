<?php

declare(strict_types=1);

namespace App\BusinessDomain\Result\Pipeline\Stages;

use App\BusinessDomain\Result\Pipeline\Payload\ResultPayload;

class GetDataFromQueryBuilderStage implements ResultPipelineStageInterface
{
    public function __invoke(ResultPayload $payload): ResultPayload
    {
        if (($queryBuilder = $payload->getQueryBuilder()) === null) {
            throw new \RuntimeException('Failed to get query builder from result-pipeline payload');
        }

        $payload->setQueryData($queryBuilder->get(['content.*', 'content_user.like_status']));
        return $payload;
    }
}
