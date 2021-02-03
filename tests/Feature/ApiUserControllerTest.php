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

    private const INPUT_DATA_PROVIDER_REGISTER = [
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

    private const EXPECTED_DATA_PROVIDER_REGISTER = [
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


    public function testRegisterCreatesNewUser()
    {
        // build base url for core-api requests
        $baseUrl = env('APP_URL') . '/api';

        // for each $input in $inputData fire a api request to the /register-api-user endpoint and retrieve the data
        $index = 0;
        foreach (self::INPUT_DATA_PROVIDER_REGISTER as $message => $input) {
            // Fire API request
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
            self::assertEquals(self::EXPECTED_DATA_PROVIDER_REGISTER[$index], $actualData);
            $index++;
        }
    }
}
