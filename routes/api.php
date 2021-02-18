<?php

use Illuminate\Http\Request;

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
// User
Route::post('login','API\AuthController@Login');
Route::post('register', 'API\AuthController@Register');
Route::get('logout','API\AuthController@Logout');

// Posts
Route::post('post/create','API\PostController@create')->middleware('jwtAuth');
Route::post('post/delete','API\PostController@delete')->middleware('jwtAuth');
Route::post('post/update','API\PostController@update')->middleware('jwtAuth');
Route::get('posts','API\PostController@posts')->middleware('jwtAuth');
// Route::get('posts/my_posts','Api\PostsController@myPosts')->middleware('jwtAuth');

//comment
Route::post('comments/create','Api\CommentController@create')->middleware('jwtAuth');
Route::post('comments/delete','Api\CommentController@delete')->middleware('jwtAuth');
Route::post('comments/update','Api\CommentController@update')->middleware('jwtAuth');
Route::post('posts/comments','Api\CommentController@comments')->middleware('jwtAuth');

// likes
Route::post('posts/like','Api\LikesController@like')->middleware('jwtAuth');