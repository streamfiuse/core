<?php

namespace Tests\Http\Controllers\Api;

use App\Models\Content;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ContentControllerTest extends TestCase
{
    use DatabaseMigrations;

    private string $baseUrl;

    public function setUp(): void
    {
        parent::setUp();
        $this->baseUrl = env('APP_URL') . '/api';

        Http::post($this->baseUrl . '/register-api-user', [
            'name' => 'tester',
            'email' => 'tester@email.com',
            'password' => 'test',
            'master_password' => 'lufin0205'
        ]);
    }

    public function testIndexReturnsAllContents(): void
    {
        Content::factory()->count(100)->create();

        $bearerToken = Http::post($this->baseUrl . '/login-api-user', [
           'email' => 'tester@email.com',
           'password' => 'test'
       ])->json('token');

       $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $bearerToken
       ])->get($this->baseUrl . '/contents')->json('data');

       self::assertGreaterThanOrEqual(100, sizeof($response));
    }
}
