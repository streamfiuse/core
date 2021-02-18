<?php

namespace Tests\Http\Controllers\Api;

use App\Http\Controllers\ContentController;
use App\Models\Content;
use App\Models\User;
use App\Traits\ApiUserAuthenticationTrait;
use Database\Factories\ContentFactory;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ContentControllerTest extends TestCase
{
    private string $baseUrl;
    private User $user;

    const CONTENT_COUNT = 100;

    public function setUp(): void
    {
        parent::setUp();

        $this->baseUrl = env('APP_URL') . '/api';
        $this->user =  User::factory()->make();
    }

    public function provideStoreCreatesNewContentData(): array
    {
        return [
            'Input' =>
                [
                    [
                        'title' => 'officias',
                        'release_date' => '1993-01-09',
                        'content_type' => 'short_film',
                        'genre' => json_encode(['genre1' => 'horror', 'genre2' => 'splatter']),
                        'tags' => json_encode(['tag1' => 'horror', 'tag2' => 'splatter']),
                        'runtime' => 149,
                        'short_description' => 'Aliquam sint provident repellendus aspernatur. Impedit et molestiae fugiat. Laudantium fuga deleniti dolor maxime earum. In ullam quia omnis asperiores.',
                        'cast' => json_encode(['starring1' => 'Fin Biessler', 'starring2' => 'Luis Platzer']),
                        'directors' => json_encode(['director1' => 'Fin Biessler', 'director2' => 'Luis Platzer']),
                        'age_restriction' => '12',
                        'poster_url' => 'http://morar.info/iusto-non-quae-voluptate-amet-inventore',
                        'youtube_trailer_url' => 'http://wehner.org/minus-doloremque-qui-autem-officia-enim',
                        'production_company' => 'Hand-Wolff',
                        'seasons' => 15,
                        'average_episode_count' => 13,
                    ]
                ],
        ];
    }

    /**
     * @dataProvider provideStoreCreatesNewContentData
     */
    public function testStoreCreatesNewContent(array $input): void
    {
        $this->actingAs($this->user)
            ->postJson(
                '/api/content',
                $input
            )->assertJson([
                'status' => 'success',
                'content_created' => $input,
                'message' => 'Successfully created a new content entry'
            ]);
    }

    public function testIndexReturnsAllContents(): void
    {
        Content::factory()->count(100)->create();

        $responseData = $this->actingAs($this->user)
        ->getJson(
            '/api/content'
        )->json('data');

        self::assertEquals(100, sizeof($responseData));
    }
}
