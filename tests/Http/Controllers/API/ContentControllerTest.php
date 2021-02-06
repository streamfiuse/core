<?php

namespace Tests\Http\Controllers\API;

use App\Http\Controllers\API\ContentController;
use App\Models\Content;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentControllerTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Content::factory()->count(100)->create();
    }

    public function testIndexReturnsAllContents(): void
    {

    }
}
