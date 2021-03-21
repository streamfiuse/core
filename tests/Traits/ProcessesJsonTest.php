<?php

namespace Tests\Traits;

use App\Traits\ProcessesJson;
use PHPUnit\Framework\TestCase;

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

        self::assertEquals($isJson, $expected);
    }
}
