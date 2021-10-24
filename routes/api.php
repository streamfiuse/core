<?php

declare(strict_types=1);

use App\Http\Controllers\Fiuselist\FiuselistController;
use App\Http\Controllers\Content\ContentController;
use App\Http\Controllers\User\UserController;
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


Route::middleware('auth:sanctum')->group(function () {
    Route::get('user/login', [UserController::class, 'loggedInUser']);
    Route::post('user/logout', [UserController::class, 'logout']);
    Route::get('content/multiple/{content_ids}', [ContentController::class, 'showMultiple']);
    Route::apiResource('content', ContentController::class);
    Route::get('fiuselist/user', [FiuselistController::class, 'getFiuselistOfCurrentlyLoggedInUser']);
    Route::post('fiuselist/user/add', [FiuselistController::class, 'addContentToFiuselistOfCurrentlyLoggedInUser']);
});
