<?php

namespace Tests\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiUserControllerTest extends TestCase
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
                    'password' => 'test',
                    'master_password' => 'lufin0205'
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
                    'password' => 'test',
                    'master_password' => 'lufin0205'
                ]
            ],
            'Valid input' => [
                [
                    'status' => 'success',
                    'message' => 'Successfully created a new user!',
                    'data' => [
                        'name' => 'test',
                        'email' => 'test@mail.com',
                    ]
                ],
                [
                    'name' => 'test',
                    'email' => 'test@mail.com',
                    'password' => 'test',
                    'master_password' => 'lufin0205'
                ]
            ]
        ];
    }

    /**
     *
     * Should be straight forward
     * (For every pair of in and output (from dataprovider) one assertion)
     *
     * @dataProvider provideRegisterCreatesNewUserData
     * @param array $expectedResult
     * @param array $input
     */
    public function testRegisterCreatesNewUser(array $expectedResult, array $input): void
    {
        $response = $this->postJson('/api/register-api-user',
            $input
        );
        $response
            ->assertJson($expectedResult);
    }

    public function provideCorrectLoginAuthenticatesNewUserData(): array
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
            ],
        ];
    }

    /**
     *
     * When logging in with correct credentials the correct output is given and the login
     * process works
     *
     * @dataProvider provideCorrectLoginAuthenticatesNewUserData()
     * @param array $expectedResponse
     * @param array $input
     */

    public function testCorrectLoginAuthenticatesNewUser(array $expectedResponse): void
    {
        $bearerToken = $this->postJson('/api/login-api-user', [
                'email' => 'tester@mail.com',
                'password' => 'test'
        ])->json('token');

        $response = $this->withHeaders(['Authorization' => 'Bearer' . $bearerToken])->getJson('/api/logged-in-user');

        $response->assertJson($expectedResponse);
    }

    public function testNoLoginRequestYieldsNoLoggedInUser(): void
    {
        $this->withHeaders(['Authorization' => ''])->getJson('/api/logged-in-user')->assertStatus(401);
    }

    public function provideAuthenticationWithWrongPasswordFailsData(): array
    {
        return [
            'Input' => [
                [
                    'status' => 'failed',
                    'login' => false,
                    'message' => 'Invalid password'
                ],
            ],
        ];
    }

    /**
     * @dataProvider provideAuthenticationWithWrongPasswordFailsData
     * @param array $expectedResponse
     * @param $input array
     */
    public function testAuthenticationWithWrongPasswordFails(array $expectedResponse): void
    {
        $response = $this->postJson( '/api/login-api-user', [
            'email' => 'tester@mail.com',
            'password' => 'testPw'
        ]);

        $response->assertJson($expectedResponse);
    }

    public function provideLogoutLogsOutUserWithCorrectTokenData(): array
    {
        return [
            'Correct Input' => [
                302,
                [
                    'email' => 'tester@email.com',
                    'password' => 'test',
                ],
            ],
        ];
    }

    /**
     * @dataProvider provideLogoutLogsOutUserWithCorrectTokenData
     * @param int $expectedHttpStatus
     * @param array $input
     */
    public function testLogoutLogsOutUserWithCorrectToken(int $expectedHttpStatus, array $input): void
    {
        $bearerToken = $this->postJson('/api/login-api-user', $input)->json('token');

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $bearerToken
        ])->postJson('/api/logout-api-user');

        $response  = $this->withHeaders([
            'Authorization' => 'Bearer ' . $bearerToken
        ])->get('/api/logged-in-user');

        $response->assertStatus($expectedHttpStatus);
    }
}
