<?php

declare(strict_types=1);

namespace Tests\Feature\Controller;

use Tests\TestCase;

class UserControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->postJson('/api/user/register', [
            'name' => 'tester',
            'email' => 'tester@email.com',
            'password' => 'testerpassword',
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
                    'password' => 'testerpassword',
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
                    'password' => 'testerpassword',
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
                    'password' => 'testerpassword',
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
     */
    public function testRegisterCreatesNewUser(array $expectedResult, array $input): void
    {
        $response = $this->postJson(
            '/api/user/register',
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
                        'email' => 'tester@email.com'
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
     */

    public function testCorrectLoginAuthenticatesNewUser(array $expectedResponse): void
    {
        $bearerToken = $this->postJson('/api/user/login', [
                'email' => 'tester@email.com',
                'password' => 'testerpassword'
        ])->json('token');

        $response = $this->withHeaders(['Authorization' => 'Bearer' . $bearerToken])->getJson('/api/user/login');

        $response->assertJson($expectedResponse);
    }

    public function testNoLoginRequestYieldsNoLoggedInUser(): void
    {
        $this->withHeaders(['Authorization' => ''])->getJson('/api/user/login')->assertStatus(401);
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
     */
    public function testAuthenticationWithWrongPasswordFails(array $expectedResponse): void
    {
        $response = $this->postJson('/api/user/login', [
            'email' => 'tester@email.com',
            'password' => 'intentionally wrong password'
        ]);

        $response->assertJson($expectedResponse);
    }

    public function provideLogoutLogsOutUserWithCorrectTokenData(): array
    {
        return [
            'Correct Input' => [
                200,
                [
                    'email' => 'tester@email.com',
                    'password' => 'testerpassword',
                ],
            ],
        ];
    }

    /**
     * @dataProvider provideLogoutLogsOutUserWithCorrectTokenData
     */
    public function testLogoutLogsOutUserWithCorrectToken(int $expectedHttpStatus, array $input): void
    {
        $bearerToken = $this->postJson('/api/user/login', $input)->json('token');

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $bearerToken
        ])->postJson('/api/user/logout');

        $response  = $this->withHeaders([
            'Authorization' => 'Bearer ' . $bearerToken
        ])->get('/api/user/login');

        $response->assertStatus($expectedHttpStatus);
    }
}
