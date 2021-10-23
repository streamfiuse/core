<?php

declare(strict_types=1);

namespace Tests\Unit\BusinessDomain\Fiuselist\Rule;

use App\BusinessDomain\Fiuselist\Rule\IsFiuselistEntryAlreadyInFiuselistRule;
use App\DataDomain\Entities\Fiuselist\Factory\FiuselistEntityFactory;
use App\DataDomain\Entities\Fiuselist\Factory\FiuselistEntryEntityFactory;
use App\DataDomain\Entities\Fiuselist\FiuselistEntity;
use App\DataDomain\Entities\Fiuselist\FiuselistEntryEntity;
use Carbon\Carbon;
use Tests\TestCase;

class IsFiuselistEntryAlreadyInFiuselistRuleTest extends TestCase
{
    public function provideFiuselistData(): array
    {
        $fiuselistEntryFactory = new FiuselistEntryEntityFactory();
        $fiuselistFactory = new FiuselistEntityFactory($fiuselistEntryFactory);

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
        $fiuselistEntry =  $fiuselistEntryFactory->create(
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
        );

        $fiuselistEntry2 = $fiuselistEntryFactory->create(
            [
                    'content_id' => 666,
                    'user_id' => 2,
                    'position' => 3,
                    'like_status' => 'liked',
                    'dislike_count' => 0,
                    'free_date' => '',
                    'created_at' => Carbon::today()->toISOString(),
                    'updated_at' => ''
                ]
        );
        $fiuselist = $fiuselistFactory->create($fiuselistData);


        return [
              'Entry is in fiuselist' => [
                  $fiuselist,
                  $fiuselistEntry,
                  true
              ],
              'Entry is not in fiuselist' => [
                  $fiuselist,
                  $fiuselistEntry2,
                  false
              ]
            ];
    }

    /**
     * @dataProvider provideFiuselistData
     */
    public function testRuleReturnsCorrectBoolForInputs(FiuselistEntity $fiuselist, FiuselistEntryEntity $fiuselistEntryEntity, bool $expected): void
    {
        $rule = new IsFiuselistEntryAlreadyInFiuselistRule();

        $actual = $rule->appliesTo($fiuselist, $fiuselistEntryEntity);

        static::assertSame($expected, $actual);
    }
}
