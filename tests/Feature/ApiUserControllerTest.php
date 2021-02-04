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
        $this->baseUrl = env('APP_URL') . '/api';
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
                        'name' => 'tester',
                        'email' => 'tester@mail.com',
                    ]
                ],
                [
                    'name' => 'tester',
                    'email' => 'tester@mail.com',
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
                    'master_password' => 'lufin0205'
                ],
            ],
        ];
    }

    /**
     *
     * When logging in with correct credentials the correct output is given and the login
     * process works
     *
     * @dataProvider provideLoginAuthenticatesNewUserData()
     * @param array $expectedResult
     * @param array $input
     */
    public function testCorrectLoginAuthenticatesNewUser(array $expectedResult, array $input): void
    {
        Http::post($this->baseUrl . '/register-api-user', $input);
        $bearerToken = Http::post($this->baseUrl . '/login-api-user', [
            'email' => 'tester@mail.com',
            'password' => 'test'])->json('token');

        $expectedResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $bearerToken
        ])->get($this->baseUrl . '/logged-in-user')->body();

        self::assertEquals(json_encode($expectedResult), $expectedResponse);
    }

    public function testNoLoginRequestYieldsNoLoggedInUser(): void
    {
        self::assertEquals(405, Http::withHeaders([
            'Authorization' => 'Bearer ' . ''
        ])->get($this->baseUrl . '/logged-in-user')->status());
    }

    public function provideWrongTokenYieldsNoAuthenticationData(): array
    {
        return [
            'Input' => [
                405,
                [
                    'name' => 'tester',
                    'email' => 'tester@email.com',
                    'password' => 'test',
                    'master_password' => 'lufin0205'
                ],
            ],
        ];
    }

    /**
     * @dataProvider provideWrongTokenYieldsNoAuthenticationData
     * @param int $expectedHttpStatus
     * @param array $input
     */
    public function testWrongTokenYieldsNoAuthentication(int $expectedHttpStatus, array $input): void
    {
        Http::post($this->baseUrl . '/register-api-user', $input);
        $bearerToken = Http::post($this->baseUrl . '/login-api-user', [
            'email' => 'tester@mail.com',
            'password' => 'test'])->json('token');

        $actualHttpStatus = Http::withHeaders([
            'Authorization' => 'Bearer ' . $bearerToken . 'tokenOffset'
        ])->get($this->baseUrl . '/logged-in-user')->status();

        self::assertEquals($expectedHttpStatus, $actualHttpStatus);
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
                [
                    'name' => 'tester',
                    'email' => 'tester@email.com',
                    'password' => 'test',
                    'master_password' => 'lufin0205'
                ],
            ],
        ];
    }

    /**
     * @dataProvider provideAuthenticationWithWrongPasswordFailsData
     * @param $expectedResult array
     * @param $input array
     */
    public function testAuthenticationWithWrongPasswordFails(array $expectedResult,array $input): void
    {
        Http::post($this->baseUrl . '/register-api-user', $input);
        $actualResponse = Http::post($this->baseUrl . '/login-api-user', [
            'email' => 'tester@mail.com',
            'password' => 'testWrongPw'])->body();


        self::assertEquals(json_encode($expectedResult), $actualResponse);
    }

    public function provideLogoutLogsOutUserWithCorrectToken(): array
    {
        return [
            'Correct Input' => [
                200,
                [
                    'name' => 'tester',
                    'email' => 'tester@email.com',
                    'password' => 'test',
                    'master_password' => 'lufin0205'
                ],
            ],
        ];
    }

    /**
     * @dataProvider provideLogoutLogsOutUserWithCorrectToken
     * @param $expectedResult
     * @param $input
     */
    public function testLogoutLogsOutUserWithCorrectToken(int $expectedResult, array $input): void
    {
        Http::post($this->baseUrl . '/register-api-user', $input);
        $bearerToken = Http::post($this->baseUrl . '/login-api-user', [
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

    public function provideLogoutWhenNoUserIsLoggedInData(): array
    {
        return [
            [
                [
                    'status' => 'failed',
                    'message' => 'No user currently logged in!'
                ]
            ],
        ];
    }

    /**
     * @dataProvider provideLogoutWhenNoUserIsLoggedInData
     * @param $expectedResponse
     */
    public function testLogoutWhenNoUserIsLoggedIn($expectedResponse): void
    {
        $actualResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . ''
        ])->post($this->baseUrl . '/logout-api-user')->body();

        self::assertEquals(json_encode($expectedResponse), $actualResponse);
    }
}
