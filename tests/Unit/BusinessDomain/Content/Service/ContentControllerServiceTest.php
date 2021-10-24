<?php

declare(strict_types=1);

namespace Tests\Unit\BusinessDomain\Content\Service;

use App\BusinessDomain\Content\Service\ContentControllerService;
use App\Models\Content;
use Tests\TestCase;

class ContentControllerServiceTest extends TestCase
{
    private ContentControllerService $contentControllerService;
    private const CONTENT_COUNT = 4;

    //test
    protected function setUp(): void
    {
        parent::setUp();
        $this->contentControllerService = new ContentControllerService();
        Content::factory()->count(self::CONTENT_COUNT)->create();
    }

    public function provideIdentifiersAndRespectiveResult(): array
    {
        return [
            'Existing identifiers' => [
                [
                    1,
                    2,
                    3,
                ],
                'success'
            ],
            'Full non existing identifiers' => [
                [
                    100,
                    101,
                    102,
                ],
                'failed'
            ],
            'Existing and non existing identifiers' => [
                [
                    1,
                    2,
                    102,
                    103
                ],
                'failed'
            ]
        ];
    }

    /**
     * @dataProvider provideIdentifiersAndRespectiveResult
     */
    public function testGetContentsByIdentifiers(array $identifiers, string $expected): void
    {
        $actual = $this->contentControllerService->getContentsByIdentifiers($identifiers);

        static::assertSame($actual['status'], $expected);
    }
}
