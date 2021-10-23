<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\BusinessDomain\Authentication\UseCase\LoginUserQueryHandler;
use App\BusinessDomain\Authentication\UseCase\LogoutUserQueryHandler;
use App\BusinessDomain\Authentication\UseCase\Query\Builder\LoginUserQueryBuilder;
use App\BusinessDomain\Authentication\UseCase\Query\Builder\RegisterUserQueryBuilder;
use App\BusinessDomain\Authentication\UseCase\RegisterUserQueryHandler;
use App\Exceptions\Authentication\InvalidPasswordException;
use App\Exceptions\Authentication\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\MasterPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private RegisterUserQueryHandler $registerQueryHandler;
    private RegisterUserQueryBuilder $registerQueryBuilder;
    private LoginUserQueryBuilder $loginQueryBuilder;
    private LoginUserQueryHandler $loginQueryHandler;
    private LogoutUserQueryHandler $logoutUserQueryHandler;

    public function __construct(
        RegisterUserQueryHandler $registerQueryHandler,
        RegisterUserQueryBuilder $registerQueryBuilder,
        LoginUserQueryBuilder $loginQueryBuilder,
        LoginUserQueryHandler $loginQueryHandler,
        LogoutUserQueryHandler $logoutUserQueryHandler
    ) {
        $this->registerQueryHandler = $registerQueryHandler;
        $this->registerQueryBuilder = $registerQueryBuilder;
        $this->loginQueryBuilder = $loginQueryBuilder;
        $this->loginQueryHandler = $loginQueryHandler;
        $this->logoutUserQueryHandler = $logoutUserQueryHandler;
    }


    /**
     *
     * Register a new api user
     *
     */
    public function register(Request $request): JsonResponse
    {
        //Check that input parameters fulfill their constraints
        $validator = Validator::make($request->all(), [
            'name'  =>  'required',
            'email'  =>  'required|email|unique:users,email',
            'password'  =>  'required',
            'master_password' => 'required'
        ]);

        if ($validator->fails()) {
            // return which constraints were not met
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => 'Invalid input!',
                    'validation_errors' => $validator->errors()
                ],
                422
            );
        }

        $apiMasterPw = MasterPassword::where('name', 'API_MASTER_PW')->value('password');
        if (Hash::check($request->master_password, $apiMasterPw)) {
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');

            $registerQuery = $this->registerQueryBuilder->build($email, $name, $password);
            $user = $this->registerQueryHandler->execute($registerQuery);

            if (null !== $user) {
                return response()->json(
                    [
                        'status' => 'success',
                        'message' => 'Successfully created a new user!',
                        'data' => [
                            'name' => $user->name,
                            'email' => $user->email
                        ],
                    ],
                    201
                );
            }
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => 'Unable to create user!'
                ],
                500
            );
        }

        return response()->json(
            [
                'status' => 'failed',
                'message' => 'Master password incorrect!'
            ],
            401
        );
    }

    /**
     *
     * Login a new user to the api
     *
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
           'email' => 'required|email',
           'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => 'Invalid input!',
                    'validation_errors' => $validator->errors()
                ],
                422
            );
        }

        $loginQuery = $this->loginQueryBuilder->build(
            $request->input('email'),
            $request->input('password')
        );

        try {
            $userAndToken = $this->loginQueryHandler->execute($loginQuery);
        } catch (UserNotFoundException $e) {
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => $e->getMessage()
                ],
                422
            );
        } catch (InvalidPasswordException $e) {
            return response()->json(
                [
                    'status' => 'failed',
                    'login' => false,
                    'message' => $e->getMessage()
                ],
                401
            );
        }

        return response()->json(
            [
                'status' => 'success',
                'login' => true,
                'token' => $userAndToken['token'],
                'data' => $userAndToken['user']
            ]
        );
    }

    public function logout(): JsonResponse
    {
        $logoutSuccessful = $this->logoutUserQueryHandler->execute();
        if ($logoutSuccessful) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'The authenticated user was logged out!',
                ],
            );
        } else {
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => 'No user currently logged in!'
                ],
                500
            );
        }
    }



    /**
     *
     * Get the user that is currently logged in to the api
     *
     * @return JsonResponse
     */
    public function loggedInUser(): JsonResponse
    {
        //get the user that is currently authenticated
        $user = Auth::user();

        if (null !== $user) {
            return response()->json(['status' => 'success', 'data' => [
                'name' => $user['name'],
                'email' => $user['email']
            ]], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Currently no user is logged in!'], 401);
        }
    }
}
