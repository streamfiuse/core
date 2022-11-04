<?php

declare(strict_types=1);

namespace Tests\Feature\Controller;

use App\Models\Content;
use App\Models\User;
use Tests\TestCase;

class FiuselistControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testLikeContentRejectsMalformedRequest(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user)
            ->postJson(
                '/api/fiuselist/like/notanid'
            )->assertJson([
                'status' => 'failed',
                'message' => 'The id must be a number. The id must be greater than 0.'
            ]);
    }

    public function testLikeContentFailsWhenLikingAlreadyLikedContent(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->hasAttached(
                Content::factory()->count(1),
                ['like_status' => 'liked']
            )->create();

        $this->actingAs($user)
            ->postJson(
                '/api/fiuselist/like/1'
            )->assertJson([
                'status' => 'failed',
                'message' => 'Already liked'
            ]);
    }

    public function testLikeContentLikesNewContent(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        Content::factory()->create();

        $this->actingAs($user)
            ->postJson(
                '/api/fiuselist/like/1'
            )->assertJson([
                'status' => 'success',
            ]);

        self::assertEquals(1, $user->contents()->count());
    }

    public function testLikeContentLikesDislikedContent(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->hasAttached(
                Content::factory()->count(1),
                ['like_status' => 'disliked']
            )->create();

        $this->actingAs($user)
            ->postJson(
                '/api/fiuselist/like/1'
            )->assertJson([
                'status' => 'success',
            ]);

        $like_status = $user->contents[0]->pivot->like_status;//$user->contents()->withPivot(['like_status'])->limit(1)->get(['like_status'])->all()[0]['like_status'];

        self::assertEquals('liked', $like_status);
    }

}
