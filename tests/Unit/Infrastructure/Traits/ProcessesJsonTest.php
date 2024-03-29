<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Traits;

use App\Infrastructure\Traits\ProcessesJson;
use Tests\TestCase;

class ProcessesJsonTest extends TestCase
{
    public function provideJsonData(): array
    {
        return [
            ["asdasdasdasd", false],
            ['{"first_name": "John", "last_name": "Doe", "email": "jdoe@email.com"}', true],
            ['{"first_name": "John", "last_name": "Doe", "email": "jdoe@email.com",}', false]
        ];
    }

    /**
     * @dataProvider provideJsonData
     */
    public function testIsJsonBehavesCorrectly(string $jsonString, bool $expected): void
    {
        $processesJsonTrait = $this->getMockForTrait(ProcessesJson::class);
        $isJson = $processesJsonTrait->isJson($jsonString);

        static::assertSame($isJson, $expected);
    }
}
