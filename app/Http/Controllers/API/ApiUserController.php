<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiUserController extends Controller
{
    /**
     *
     * Register a new api user
     *
     * @param Request $request
     * @return JsonResponse
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
            return response()->json(['status' => 'failed', 'message' => 'Invalid input!', 'validation_errors' => $validator->errors()], 422);
        }

        if (password_verify($request->master_password, env('API_MASTER_PW'))) {

            $inputs = $request->all();

            //hash the password because no passwords are stored in plain text
            $inputs['password'] = Hash::make($request->password);

            $user = User::create($inputs);

            if (!is_null($user)) {
                return response()->json(['status' => 'success', 'message' => 'Successfully created a new user!', 'data' => ['name' => $user->name, 'email' => $user->email]], 201);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Unable to create user!'], 500);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Master password incorrect!'], 401);
        }
    }

    /**
     *
     * Login a new user to the api
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        //Check that input parameters fulfill their constraints
        $validator = Validator::make($request->all(), [
           'email' => 'required|email',
           'password' => 'required'
        ]);

        if ($validator->fails()) {
            // return which constraints were not met
            return response()->json(['status' => 'failed', 'message' => 'Invalid input!', 'validation_errors' => $validator->errors()], 422);
        }

        // get the respective user for the email in the request
        $user = User::where('email', $request->email)->first();

        if (is_null($user)){
            return response()->json(['status' => 'failed', 'message' => 'E-mail not found!'], 422);
        }

        // Try to authenticate the given user
        if (Auth::attempt(['email' => $request->email,'password' => $request->password])) {
            $user   = Auth::user();
            $token  = $user->createToken('token')->plainTextToken;

            return response()->json(['status' => 'success', 'login' => true, 'token' => $token, 'data' => $user], 200);
        } else {
            return response()->json(['status' => 'failed', 'login' => false, 'message' => 'Invalid password'], 401);
        }
    }

    public function logout(): JsonResponse
    {
        // Get the current logged in user
        $user = Auth::user();
        if ($user){

            // delete all access tokens related to that user
            $user->tokens()->delete();
            return response()->json(['status' => 'success', 'message' => 'The authenticated user was logged out!'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'No user currently logged in!'], 500);
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

        if (!is_null($user)) {
            return response()->json(['status' => 'success', 'data' => [
                'name' => $user['name'],
                'email' => $user['email']
            ]], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Currently no user is logged in!'], 401);
        }
    }
}
