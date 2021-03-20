<?php

namespace Tests\Entities\Fiuselist\Service;

use App\Entities\Fiuselist\Factory\FiuselistEntityFactory;
use App\Entities\Fiuselist\Factory\FiuselistEntryEntityFactory;
use App\Entities\Fiuselist\FiuselistEntity;
use App\Entities\Fiuselist\FiuselistEntryEntity;
use App\Entities\Fiuselist\Service\FiuselistEntityService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class FiuselistEntityServiceTest extends TestCase
{
    private FiuselistEntityService $fiuselistEntityService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fiuselistEntityService = new FiuselistEntityService();
    }

    public function provideFiuselistEntriesToAssocArray(): array
    {
        $fiuselistEntityFactory = new FiuselistEntityFactory(new FiuselistEntryEntityFactory());
        $fiuselistData = [
            [
                'content_id' => 10,
                'user_id' => 2,
                'position' => 1,
                'like_status' => 'liked',
                'dislike_count' => 0,
                'free_date' => '',
                'created_at' => Carbon::today()->toISOString(),
                'updated_at' => ''
            ],
            [
                'content_id' => 11,
                'user_id' => 2,
                'position' => 2,
                'like_status' => 'disliked',
                'dislike_count' => 1,
                'free_date' => Carbon::today()->addDays(30)->toISOString(),
                'created_at' => Carbon::today()->toISOString(),
                'updated_at' => ''
            ]
        ];
        $fiuselistEntity = $fiuselistEntityFactory->create($fiuselistData);

        return [
            [
               $fiuselistEntity,
               $fiuselistData
            ]
        ];
    }

    /**
     * @dataProvider provideFiuselistEntriesToAssocArray
     */
    public function testFiuselistEntriesToAssocArray(FiuselistEntity $fiuselistEntity, array $expectedFiuselistData): void
    {
        $actual = $this->fiuselistEntityService->fiuselistEntriesToAssocArray($fiuselistEntity);

        self::assertEquals($expectedFiuselistData, $actual);
    }

    public function provideAddEntryToFiuselistData(): array
    {
        $fiuselistEntryEntityFactory = new FiuselistEntryEntityFactory();
        $fiuselistEntityFactory = new FiuselistEntityFactory($fiuselistEntryEntityFactory);

        $fiuselistData = [
            [
                'content_id' => 10,
                'user_id' => 2,
                'position' => 1,
                'like_status' => 'liked',
                'dislike_count' => 0,
                'free_date' => '',
                'created_at' => Carbon::today()->toISOString(),
                'updated_at' => ''
            ],
            [
                'content_id' => 11,
                'user_id' => 2,
                'position' => 2,
                'like_status' => 'disliked',
                'dislike_count' => 1,
                'free_date' => Carbon::today()->addDays(30)->toISOString(),
                'created_at' => Carbon::today()->toISOString(),
                'updated_at' => ''
            ]
        ];
        $fiuselistEntity = $fiuselistEntityFactory->create($fiuselistData);
        $fiuselistEntryEntity = $fiuselistEntryEntityFactory->create([
            'content_id' => 12,
            'user_id' => 2,
            'position' => 3,
            'like_status' => 'liked',
            'dislike_count' => 0,
            'free_date' => '',
            'created_at' => Carbon::today()->toISOString(),
        ]);

        $expectedFiuselistEntriesData = [
            [
                'content_id' => 10,
                'user_id' => 2,
                'position' => 1,
                'like_status' => 'liked',
                'dislike_count' => 0,
                'free_date' => '',
                'created_at' => Carbon::today()->toISOString(),
                'updated_at' => ''
            ],
            [
                'content_id' => 11,
                'user_id' => 2,
                'position' => 2,
                'like_status' => 'disliked',
                'dislike_count' => 1,
                'free_date' => Carbon::today()->addDays(30)->toISOString(),
                'created_at' => Carbon::today()->toISOString(),
                'updated_at' => ''
            ],
            [
                'content_id' => 12,
                'user_id' => 2,
                'position' => 3,
                'like_status' => 'liked',
                'dislike_count' => 0,
                'free_date' => '',
                'created_at' => Carbon::today()->toISOString(),
                'updated_at' => ''
            ]
        ];

        return [
            [
                $fiuselistEntity,
                $fiuselistEntryEntity,
                $expectedFiuselistEntriesData
            ]
        ];
    }

    /**
     * @dataProvider provideAddEntryToFiuselistData
     */
    public function testAddEntryToFiuselist(
        FiuselistEntity $fiuselistEntity,
        FiuselistEntryEntity $fiuselistEntryEntity,
        array $expectedFiuselistEntriesData
    ): void
    {
        $actualFiuselist = $this->fiuselistEntityService->addEntryToFiuselist($fiuselistEntryEntity, $fiuselistEntity);
        $actualFiuselistEntriesData = $this->fiuselistEntityService->fiuselistEntriesToAssocArray($actualFiuselist);

        self::assertEquals($expectedFiuselistEntriesData, $actualFiuselistEntriesData);
    }
}
