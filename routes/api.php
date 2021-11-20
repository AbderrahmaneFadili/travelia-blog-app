<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UploadImageController;
use App\Models\PostComment;
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
////// Auther Routes
Route::post('/login', [AuthController::class, 'login']);
//get all categories
Route::get('/categories', [CategoryController::class, 'index']);
//get all posts
Route::get('/posts', [PostController::class, 'index']);


//protected routes
Route::group(['middleware' => 'auth:sanctum'], function () {

    //create post
    Route::post('/posts', [PostController::class, 'store']);

    //Update post
    Route::put('/posts/{id}', [PostController::class, 'update']);

    //Delete post
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);

    //Create post like
    Route::post('likes/{postId}', [PostLikeController::class, 'store']);

    //Delete post like
    Route::delete('likes/{likeId}', [PostLikeController::class, 'destroy']);

    //Likes Count 
    Route::get('likes/{postId}', [PostLikeController::class, 'likesCount']);

    //Add Post Comment 
    Route::post('posts/comment/{postId}', [PostCommentController::class, 'store']);
    //delete Post Comment 
    Route::delete('posts/comment/{commentId}', [PostCommentController::class, 'destroy']);

    //Get all comments by post
    Route::get('posts/comments/{postId}', [PostCommentController::class, 'allPostComments']);

    //Update Post Comment 
    Route::put('posts/comment/{commentId}', [PostCommentController::class, 'update']);



    //Upload image for a post
    Route::post('/posts/upload/image', [UploadImageController::class, 'store']);

    //logout route
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
