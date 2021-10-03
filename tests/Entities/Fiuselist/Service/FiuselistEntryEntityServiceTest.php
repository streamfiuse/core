<?php

namespace Tests\Entities\Fiuselist\Service;

use App\BusinessDomain\Fiuselist\Service\FiuselistEntryEntityService;
use App\DataDomain\Entities\Fiuselist\Factory\FiuselistEntryEntityFactory;
use App\DataDomain\Entities\Fiuselist\FiuselistEntryEntity;
use Carbon\Carbon;
use Tests\TestCase;

class FiuselistEntryEntityServiceTest extends TestCase
{
    private FiuselistEntryEntityService $fiuselistEntryEntityService;

    public function setUp(): void
    {
        parent::setUp();
        $this->fiuselistEntryEntityService = new FiuselistEntryEntityService(new FiuselistEntryEntityFactory());
    }

    public function provideFiuselistEntryEntityCreationData(): array
    {
        return [
            [
                [
                    'content_id' => 10,
                    'user_id' => 5,
                    'position' => 2,
                    'like_status' => 'liked'
                ],
                new FiuselistEntryEntity(
                    10,
                    5,
                    2,
                    'liked',
                    0,
                    '',
                    Carbon::today()->toISOString(),
                    ''
                )
            ],
            [
                [
                    'content_id' => 10,
                    'user_id' => 5,
                    'position' => 2,
                    'like_status' => 'disliked'
                ],
                new FiuselistEntryEntity(
                    10,
                    5,
                    2,
                    'disliked',
                    1,
                    Carbon::today()->addDays(30)->toISOString(),
                    Carbon::today()->toISOString(),
                    ''
                )
            ],
        ];
    }

    /**
     * @dataProvider provideFiuselistEntryEntityCreationData
     */
    public function testFiuselistEntryEntityCreationFromAttributesIsCorrect($attributes, $expected): void
    {
        $actual = $this->fiuselistEntryEntityService->createFiuselistEntryEntityFromAttributes(
            $attributes['content_id'],
            $attributes['user_id'],
            $attributes['position'],
            $attributes['like_status']
        );

        self::assertEquals($expected, $actual);
    }

    public function provideExtractionOfFiuselistEntryEntityWorksCorrectlyData(): array
    {
        return [
            [
                new FiuselistEntryEntity(
                    10,
                    5,
                    2,
                    'liked',
                    0,
                    '',
                    Carbon::today()->toISOString(),
                    ''
                ),
                [
                    'content_id' => 10,
                    'user_id' => 5,
                    'position' => 2,
                    'like_status' => 'liked',
                    'dislike_count' => 0,
                    'free_date' => '',
                    'created_at' => Carbon::today()->toISOString(),
                ],
            ],
        ];
    }

    /**
     * @dataProvider provideExtractionOfFiuselistEntryEntityWorksCorrectlyData
     */
    public function testExtractionOfFiuselistEntryEntityWorksCorrectly(FiuselistEntryEntity $fiuselistEntryEntity, array $expectedAttributes): void
    {
        $actual = $this->fiuselistEntryEntityService->extractAttributesArrayFromFiuselistEntryEntity($fiuselistEntryEntity);

        self::assertEquals($expectedAttributes, $actual);
    }
}
