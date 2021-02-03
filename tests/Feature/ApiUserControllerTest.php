<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiUserControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $baseUrl;

    public function setUp(): void
    {
        parent::setUp();
        $this->baseUrl =  env('APP_URL') . '/api';
    }

    public function provideRegisterCreatesNewUserData(): array
    {
        return [
          'Missing e-mail' => [
            [
                'status' => 'failed',
                'message' => 'Invalid input!',
                'validation_errors' => [
                    'email' => ['The email field is required.']
                ]
            ],
            [
                'name' => 'tester',
                'password' => 'test'
            ]
          ],
          'Wrong e-mail format' => [
              [
                  'status' => 'failed',
                  'message' => 'Invalid input!',
                  'validation_errors' => [
                      'email' => ['The email must be a valid email address.']
                  ]
              ],
              [
                  'name' => 'tester',
                  'email' => 'myemail',
                  'password' => 'test'
              ]
          ],
          'Valid input' => [
              [
                  'status' => 'success',
                  'message' => 'Successfully created a new user!',
                  'data' => [
                      'name' => 'tester',
                      'email' => 'tester@mail.com'
                  ]
              ],
              [
                  'name' => 'tester',
                  'email' => 'tester@mail.com',
                  'password' => 'test'
              ]
          ]
        ];
    }

    /**
     * @dataProvider provideRegisterCreatesNewUserData
     * @param array $expectedResult
     * @param array $input
     */
    public function testRegisterCreatesNewUser(array $expectedResult, array $input): void
    {
        self::assertEquals(json_encode($expectedResult), Http::post($this->baseUrl . '/register-api-user', $input)->body());
    }

    public function provideLoginAuthenticatesNewUserData(): array
    {
        return [
            'Correct Input' => [
              [
                  'status' => 'success',
                  'data' => [
                      'name' => 'tester',
                      'email' => 'tester@mail.com'
                  ]
              ],
              [
                  'name' => 'tester',
                  'email' => 'tester@email.com',
                  'password' => 'test',
              ],
            ],
        ];
    }

    /**
     * @dataProvider provideLoginAuthenticatesNewUserData()
     * @param array $expectedResult
     * @param array $input
     */
    public function testCorrectLoginAuthenticatesNewUser(array $expectedResult, array $input): void
    {
        Http::post($this->baseUrl . '/register-api-user', $input);
        $bearerToken = Http::post($this->baseUrl . '/login-api-user' , [
            'email' => 'tester@mail.com',
            'password' => 'test'])->json('token');

        $expectedResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $bearerToken
        ])->get($this->baseUrl . '/logged-in-user')->body();

        self::assertEquals(json_encode($expectedResult), $expectedResponse);
    }

    //TODO test with wrong types of input, left off parameters, wrong pw etc.

    public function provideLogoutLogsOutUserWithCorrectToken(): array
    {
        return [
            'Correct Input' => [
                405,
                [
                    'name' => 'tester',
                    'email' => 'tester@email.com',
                    'password' => 'test',
                ],
            ],
        ];
    }

    /**
     * @dataProvider provideLogoutLogsOutUserWithCorrectToken
     * @param $expectedResult
     * @param $input
     */
    public function testLogoutLogsOutUserWithCorrectToken($expectedResult, $input): void
    {
        Http::post($this->baseUrl . '/register-api-user', $input);
        $bearerToken = Http::post($this->baseUrl . '/login-api-user' , [
            'email' => 'tester@mail.com',
            'password' => 'test'])->json('token');
        Http::withHeaders([
            'Authorization' => 'Bearer ' . $bearerToken
        ])->post($this->baseUrl . '/logout-api-user');
        $actualHttpStatus = Http::withHeaders([
            'Authorization' => 'Bearer ' . $bearerToken
        ])->get($this->baseUrl . '/logged-in-user')->status();
        self::assertEquals($expectedResult, $actualHttpStatus);
    }

    //TODO Test behaviour when no user is logged in
}
