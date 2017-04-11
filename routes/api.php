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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/topics', 'topicsController@index')->middleware('api');

Route::post('/question/follower', 'QuestionFollowController@follower')->middleware('auth:api');

Route::post('/question/follow', 'QuestionFollowController@followThisQuestion')->middleware('auth:api');

Route::get('/user/followers/{id}','FollowersController@index')->middleware('api');
Route::post('/user/follow','FollowersController@follow')->middleware('auth:api');

Route::post('/answer/{id}/votes/users','VotesController@users')->middleware('auth:api');
Route::post('/answer/vote','VotesController@vote')->middleware('auth:api');
Route::post('/message/store','MessagesController@store')->middleware('auth:api');

Route::get('/answer/{id}/comments','CommentsController@answer')->middleware('api');
Route::get('/question/{id}/comments','CommentsController@question')->middleware('api');
Route::post('/comment','CommentsController@store')->middleware('auth:api');
