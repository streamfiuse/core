<?php

declare(strict_types=1);

namespace App\BusinessDomain\Result\Pipeline\Stages;

use App\BusinessDomain\Result\Pipeline\Payload\ResultPayload;

interface ResultPipelineStageInterface
{
    public function __invoke(ResultPayload $payload): ResultPayload;
}
