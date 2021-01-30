<?php

namespace App\Http\Controllers;

use App\Models\User;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        //Check that input parameters fulfill their constraints
        $validator = Validator::make($request->all(), [
            'name'  =>  'required',
            'email'  =>  'required|email|unique:users,email',
            'password'  =>  'required'
        ]);

        if ($validator->fails()) {
            // return which constraints were not met
            return response()->json(['status' => 'failed', 'message' => 'Invalid input!', 'validation_errors' => $validator->errors()], 422);
        }

        $inputs = $request->all();

        //hash the password because no passwords are stored in plain text
        $inputs['password'] = Hash::make($request->password);

        $user = User::create($inputs);

        if (!is_null($user)) {
            return response()->json(['status' => 'success', 'message' => 'Successfully created a new user!', 'data' => $user],201);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Unable to create user!'], 500);
        }
    }

    /**
     *
     * Login a new user to the api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
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

    /**
     *
     * Get the user that is currently logged in to the api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loggedInUser()
    {
        //get the user that is currently authenticated
        $user = Auth::user();

        if (!is_null($user)) {
            return response()->json(['status' => 'success', 'data' => $user], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Currently no user is logged in!'], 401);
        }
    }
}
