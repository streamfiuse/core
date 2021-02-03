<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiUserControllerTest extends TestCase
{
    use RefreshDatabase;

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
     */
    public function testRegisterCreatesNewUser($expectedResult, $input): void
    {
        // build base url for core-api requests
        $baseUrl = env('APP_URL') . '/api';

        self::assertEquals(json_encode($expectedResult), Http::post($baseUrl . '/register-api-user', $input)->body());
    }
}
