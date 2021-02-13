<?php

namespace Tests\Http\Controllers\Api;

use App\Http\Controllers\ContentController;
use Tests\TestCase;

class ContentControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->postJson('/api/register-api-user', [
            'name' => 'tester',
            'email' => 'tester@mail.com',
            'password' => 'test',
            'master_password' => 'lufin0205'
        ]);
    }

    public function testIndexReturnsAllContents(): void
    {

    }
}
