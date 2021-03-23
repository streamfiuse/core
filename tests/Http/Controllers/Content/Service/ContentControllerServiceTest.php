<?php

namespace Tests\Http\Controllers\Content\Service;

use App\Http\Controllers\Content\Service\ContentControllerService;
use App\Models\Content;
use Tests\TestCase;


class ContentControllerServiceTest extends TestCase
{
    private ContentControllerService $contentControllerService;
    private const CONTENT_COUNT = 4;

    public function setUp(): void
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
                  2
              ],
              'success'
          ]
        ];
    }

    /**
     * @dataProvider provideIdentifiersAndRespectiveResult
     */
    public function testGetContentsByIdentifiers(array $identifiers, string $expected): void
    {
        $actual = $this->contentControllerService->getContentsByIdentifiers($identifiers);

        self::assertEquals($actual['status'], $expected);
    }
}
