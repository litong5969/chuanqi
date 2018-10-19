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

Route::get('/tags', 'TagsController@index')->middleware('api');

Route::post('/article/follower', 'ArticleFollowController@follower')->middleware('auth:api');

Route::post('/article/follow', 'ArticleFollowController@followThisArticle')->middleware('auth:api');

Route::get('/user/followers/{id}','FollowersController@index');
Route::post('/user/follow','FollowersController@follow');

Route::post('/instalment/{id}/votes/users','VotesController@users');
Route::post('/instalment/vote','VotesController@vote');

Route::post('/message/store','MessagesController@store');

Route::get('instalment/{id}/comments','CommentsController@instalment');
Route::get('article/{id}/comments','CommentsController@article');
Route::post('comment','CommentsController@store');