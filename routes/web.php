<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ArticlesController@index');

Route::post('/deploy','DeploymentController@deploy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('email/verify/{token}',['as'=>'email.verify','uses'=>'EmailController@verify']);

//Route::paginate('articles', 'ArticlesController@index');
Route::resource('articles','ArticlesController',['name'=>[
    'create'=>'articles.create',
    'show'=>'articles.show',
]]);

//Route::post('articles/{article}/instalment','InstalmentsController@store');
Route::resource('instalment','InstalmentsController');


Route::get('articles/{article}/follow','ArticleFollowController@follow');
Route::get('search','SearchController@index');

Route::get('notifications','NotificationsController@index');
Route::get('notifications/{notification}','NotificationsController@show');

Route::get('avatar','UsersController@avatar');
Route::post('avatar','UsersController@changeAvatar');

Route::get('password','PasswordController@password');
Route::post('password/update','PasswordController@update');

Route::get('setting','UserSettingController@index');
Route::post('setting','UserSettingController@store');

Route::get('inbox','InboxController@index');
Route::get('inbox/{dialogId}','InboxController@show');
Route::post('inbox/{dialogId}/store','InboxController@store');
