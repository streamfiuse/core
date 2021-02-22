<?php

namespace Tests\Http\Controllers\Api;

use App\Models\Content;
use App\Models\User;
use Tests\TestCase;

class ContentControllerTest extends TestCase
{
    const CONTENT_COUNT = 100;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user =  User::factory()->make();
    }

    public function testIndexReturnsAllContents(): void
    {
        Content::factory()->count(self::CONTENT_COUNT)->create();

        $responseData = $this->actingAs($this->user)
        ->getJson(
            '/api/content'
        )->json('data');

        self::assertEquals(self::CONTENT_COUNT, sizeof($responseData));
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
                        'genre'  => '{"genre1": "Horror", "genre2": "Splatter"}',
                        'tags'  => '{"tag1": "Horror", "tag2": "Splatter"}',
                        'runtime' => 149,
                        'short_description' => 'Aliquam sint provident repellendus aspernatur. Impedit et molestiae fugiat. Laudantium fuga deleniti dolor maxime earum. In ullam quia omnis asperiores.',
                        'cast'  => '{"starring1": "Fin Bießler", "starring2": "Luis Platzer"}',
                        'directors' => '{"director1": "Fin Bießler", "director2": "Luis Platzer"}',
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
     * @param array $input
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

    public function testShowReturnsCorrectJsonWhenIdIsValid():void
    {
        $expectedContent = Content::factory()->make();
        $expectedContent->save();

        $actualContent = $this->actingAs($this->user)
            ->getJson(
                '/api/content/' . $expectedContent->id
            )->assertStatus(200)->json('content');


        self::assertEquals(json_decode(json_encode($expectedContent), true), $actualContent);
    }

    public function testShowReturnsCorrectJsonWhenIdIsInvalid(): void
    {
        $expectedContent = Content::factory()->make();
        $expectedContent->save();

        $actualContent = $this->actingAs($this->user)
            ->getJson(
                '/api/content/' . '-1'
            )->assertStatus(404)->json();


        self::assertEquals(['status' => 'failed', 'message' => 'Could not find content with such an identifier'], $actualContent);
    }

    public function testUpdateReturnsCorrectJsonIfIdIsValid(): void
    {
        $content = Content::factory()->make();
        $content->save();

        $alteredContentArray = $this->actingAs($this->user)
            ->patchJson(
                '/api/content/' . $content->id,
                [
                    'title' => 'A test title'
                ]
            )->json('altered_content');

        $content->setAttribute('title', 'A test title');

        $contentArray = $content->getAttributes();

        $contentArray['updated_at'] = null;
        $alteredContentArray['updated_at'] = null;
        $contentArray['created_at'] = null;
        $alteredContentArray['created_at'] = null;

        self::assertEquals($contentArray, $alteredContentArray);
    }

    public function provideUpdateReturnsCorrectJsonIfIdIsInvalidData(): array
    {
        return [
            'Input' =>
                [
                    [
                        'status' => 'failed',
                        'message' => 'Could not find content with such an identifier'
                    ]
                ],
        ];
    }

    /**
     * @dataProvider provideUpdateReturnsCorrectJsonIfIdIsInvalidData
     * @param array $expectedResponse
     */
    public function testUpdateReturnsCorrectJsonIfIdIsInvalid(array $expectedResponse): void
    {
        $response = $this->actingAs($this->user)
            ->patchJson(
                '/api/content/' . '-1',
                [
                    'title' => 'A test title'
                ]
            )->assertStatus(404)->json();

        self::assertEquals($response, $expectedResponse);
    }

    public function provideUpdateCatchesInvalidInputAndSetsCorrectStatusCodeData(): array
    {
        return [
            'Tags no json' => [
                [
                    'tags' => 'asdafg'
                ]
            ],
            'Genre no json' => [
                [
                    'genre' => 'asdafg'
                ]
            ],
            'Poster url no url' => [
                [
                    'poster_url' => 'asdafg'
                ]
            ],
            'Runtime negative' => [
                [
                    'runtime' => -123
                ]
            ],
            'Release date no date' => [
                [
                    'release_date' => 'asdasd'
                ]
            ]
        ];
    }

    /**
     * @dataProvider provideUpdateCatchesInvalidInputAndSetsCorrectStatusCodeData
     * @param array $input
     */
    public function testUpdateCatchesInvalidInputAndSetsCorrectStatusCode(array $input): void
    {
        $content = Content::factory()->make();
        $content->save();

        $this->actingAs($this->user)
            ->patchJson(
                '/api/content/' . $content->id,
                $input
            )->assertStatus(422)->assertJsonStructure([
                'status',
                'message',
                'validation_errors'
            ]);

    }

    public function testUpdateReturnsCorrectJsonWhenNoInputIsGiven(): void
    {
        $content = Content::factory()->make();
        $content->save();

        $this->actingAs($this->user)
            ->patchJson(
                '/api/content/' . $content->id,
                []
            )->assertStatus(422)->assertJson([
                'status' => 'failed',
                'message' => 'Missing input!',
            ]);
    }

    public function testDestroyDeletesContentIfIdIsValid(): void
    {
        $content = Content::factory()->make();
        $content->save();

        $this->actingAs($this->user)
            ->deleteJson(
                '/api/content/' . $content->id
            )->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Content deleted successfully'
            ]);
    }

    public function testDestroyNotDeletesContentIfIdIsInvalid(): void
    {
        $this->actingAs($this->user)
            ->deleteJson(
                '/api/content/' . '-1'
            )->assertStatus(404)
            ->assertJson([
                'status' => 'failed',
                'message' => 'Could not find content with such an identifier'
            ]);
    }
}
