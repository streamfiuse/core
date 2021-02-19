<?php

namespace Tests\Http\Controllers\Api;

use App\Models\Content;
use App\Models\User;
use Tests\TestCase;
use function Illuminate\Events\queueable;

class ContentControllerTest extends TestCase
{
    private User $user;

    const CONTENT_COUNT = 100;

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

    public function testUpdateAltersContentsValuesIfIdIsValid(): void
    {
        $content = Content::factory()->make();
        $content->save();

        $alteredContent = $this->actingAs($this->user)
            ->patchJson(
                '/api/content/' . $content->id,
                [
                    'title' => 'A test title'
                ]
            )->json('altered_content');

        $content->title = 'A test title';

        self::assertEquals($content, $alteredContent);
    }

    public function testDestroyDeletesCorrectContent(): void
    {
        $content = Content::factory()->make();
        $content->save();

        $this->actingAs($this->user)
            ->deleteJson(
                '/api/content/' . $content->id
            )->assertStatus(204);

        $this->actingAs($this->user)
            ->getJson(
                '/api/content' . $content->id
            )
            ->assertJson([
                'status' => 'failed',
                'message' => 'No such content matching the given Identifier!'
            ]);
    }
}
