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

        // Prepare different input data sets
        $inputData = [
            0 => [
                'name' => 'tester',
                'password' => 'test'
            ],

            1 => [
              'name' => 'tester',
              'email' => 'myemail',
              'password' => 'test'
            ],

             2 => [
                'name' => 'tester',
                'email' => 'tester@mail.com',
                'password' => 'test'
            ]
        ];

        // Prepare the respective expected data
        $expectedData = [
            0 => [
                'status' => 'failed',
                'name' => null,
                'email' => null,
                'http_status' => '422'
            ],
            1 => [
                'status' => 'failed',
                'name' => null,
                'email' => null,
                'http_status' => '422'
            ],
            2 => [
                'status' => 'success',
                'name' => 'tester',
                'email' => 'tester@mail.com',
                'http_status' => 201
            ]
        ];

        // for each $input in $inputData fire a api request to the /register-api-user endpoint and retrieve the data
        $index = 0;
        foreach ($inputData as $message => $input) {
            $actualResponse = Http::post($baseUrl . '/register-api-user', $input);

            // Some data preprocessing
            // purify the data in the response in the $actualData array
            $actualData['status'] = $actualResponse->json('status');
            if ($index === 2) {
                $actualData['name'] = $actualResponse->json('data')['name'];
                $actualData['email'] = $actualResponse->json('data')['email'];
            } else {
                $actualData['name'] = null;
                $actualData['email'] = null;
            }
            $actualData['http_status'] = (string) $actualResponse->status();

            // assert that the corresponding expectedData and actualData are the same
            self::assertEquals($expectedData[$index], $actualData);
            $index++;
        }
    }
}
