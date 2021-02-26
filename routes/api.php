<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ContentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('user/register', [UserController::class, 'register']);
Route::post('user/login', [UserController::class, 'login'])->name('login');


Route::middleware('auth:sanctum')->group(function (){
    Route::get('user/login', [UserController::class, 'loggedInUser']);
    Route::post('user/logout', [UserController::class, 'logout']);
    Route::apiResource('content', ContentController::class);
});
