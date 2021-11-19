<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
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

////// public routes
////// Auth Routes
//register route
Route::post('/register', [AuthController::class, 'register']);
//login route
Route::post('/login', [AuthController::class, 'login']);


//protected routes
Route::group(['middleware' => 'auth:sanctum'], function () {

    //get all categories
    Route::get('/categories', [CategoryController::class, 'index']);
    //get all posts
    Route::get('/posts', [PostController::class, 'index']);
    //create post
    Route::post('/posts', [PostController::class, 'store']);

    //logout route
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
