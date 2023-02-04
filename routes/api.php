<?php

use Illuminate\Http\Request;
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
Route::post('register',[\App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('login',[\App\Http\Controllers\API\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    /// user
    Route::get('users/{id}',[\App\Http\Controllers\API\UsersController::class, 'show']);
    Route::put('users/{id}',[\App\Http\Controllers\API\UsersController::class, 'update']);
    //youtube video
    Route::get('youtube/{id}',[\App\Http\Controllers\API\YoutubeController::class, 'show']);
    Route::post('youtube',[\App\Http\Controllers\API\YoutubeController::class, 'store']);
    Route::post('youtube/{id}',[\App\Http\Controllers\API\YoutubeController::class, 'destroy']);

    //songs
    Route::post('song',[\App\Http\Controllers\API\SongController::class, 'store']);
    Route::delete('song/{id}/{user_id}',[\App\Http\Controllers\API\SongController::class, 'destroy']);
    Route::get('user/{user_id}/songs', [\App\Http\Controllers\API\SongsByUserController::class, 'index']);
    ///post
    Route::get('posts',[\App\Http\Controllers\API\PostsController::class, 'index']);
    Route::get('posts/{id}',[\App\Http\Controllers\API\PostsController::class, 'show']);
    Route::post('store_posts', [\App\Http\Controllers\API\PostsController::class, 'store']);
    Route::put('posts_update/{id}',[\App\Http\Controllers\API\PostsController::class, 'update']);
    Route::delete('posts/{id}',[\App\Http\Controllers\API\PostsController::class, 'destroy']);
    Route::get('user/{user_id}/posts', [\App\Http\Controllers\API\PostByUserController::class, 'index']);
    ////user log out
    Route::post('logout',[\App\Http\Controllers\API\AuthController::class, 'logout']);


});
