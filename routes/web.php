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


Route::get('admin/login', 'AdminLoginController@getlogin');
Route::post('admin/login', 'AdminLoginController@postlogin');

Route::get('admin/logout', 'AdminLoginController@logout')->name('admin.logout');


Route::group([ 'prefix' => 'admin', 'middleware' => 'admin' ], function(){

	// admin/users/
	Route::resource('users', 'UserController');

	// admin/categories/
	Route::resource('categories', 'CategoryController', ['except' => 'show']);
	Route::get('categories/{slug}', 'CategoryController@show')->name('categories.show')->where('slug', '[\w\d\-\_]+');

	// admin/topics/
	Route::resource('topics', 'TopicController', ['except' => 'show']);
	Route::get('topics/{slug}', 'TopicController@show')->name('topics.show')->where('slug', '[\w\d\-\_]+');

	// admin/questions/
	Route::resource('questions', 'QuestionController');
	Route::get('/select-ajax/{category_id}', 'AjaxSelectController@selectAjax');

	// admin/answers/
	Route::resource('answers', 'AnswerController', ['only' => 'index']);

});

/*===================================================================================================*/
	Auth::routes();
	
	Route::get('logout', 'HomepageController@logout')->name('logout');

	Route::get('/', 'HomepageController@index');
	Route::get('about', 'HomepageController@about');

	Route::get('contact', 'HomepageController@getcontact');
	Route::post('contact', 'HomepageController@postcontact');
	
	Route::get('profile/{id}', 'HomepageController@getProfile')->name('user.profile');
	Route::post('profile/{id}', 'HomepageController@postProfile')->name('user.update');

	Route::get('category/{id}', 'QuizController@category')->name('category');
	Route::get('topics/{id}', 'QuizController@topic')->name('topic');

	Route::get('question', 'QuizController@correct');
	// OAuth Routes
	Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
	Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');
