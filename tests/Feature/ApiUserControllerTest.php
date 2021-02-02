<?php

namespace Tests\Feature;

use App\Http\Controllers\ApiUserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterCreatesNewUser()
    {
        // build base url for core-api requests
        $baseUrl = env('APP_URL') . '/api';

        $expectedData = [
            'status' => 'success',
            'name' => 'tester',
            'email' => 'tester@mail.com',
        ];

        // get actual response by post requesting the api
        $actualResponse = Http::post($baseUrl . '/register-api-user', [
           'name' => 'tester',
           'email' => 'tester@mail.com',
           'password' => 'test'
        ]);

        // prepare response for assertion i.e. extract the data which is to be asserted
        $actualData['status'] = $actualResponse->json('status');
        $actualData['name'] = $actualResponse->json('data')['name'];
        $actualData['email'] = $actualResponse->json('data')['email'];

        self::assertEquals($expectedData, $actualData);
    }
}
