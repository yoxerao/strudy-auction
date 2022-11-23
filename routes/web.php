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
// Home
Route::get('/', 'HomeController@show')->name('homepage');


// Cards
Route::get('cards', 'CardController@list');
Route::get('cards/{id}', 'CardController@show');

// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('recovery', 'Auth\PasswordResetController@showSendLinkForm')->name('showLinkForm');
Route::post('recovery', 'Auth\PasswordResetController@sendLink')->name('sendLink');

//User
Route::get('user/{id}', 'UserController@show')->name('userProfile');
Route::get('user/{id}/edit', 'UserController@info_edit')->name('editUser'); // IMPORTANTE CRIAR POLICY PARA IMPEDIR EDIT SE NAO FOR AUTENTICADO OU ADMIN
Route::put('user/{id}/edit', 'UserController@edit')->name('editProfile');
Route::get('user/{id}/editpass', 'UserController@info_edit_pass')->name('editPass_info');
Route::put('user/{id}/editpass', 'UserController@edit_pass')->name('editPass'); // IMPORTANTE CRIAR POLICY PARA IMPEDIR EDIT SE NAO FOR AUTENTICADO

//Admin
Route::get('admin/{id}', 'AdminController@show')->name('adminProfile');

//Search
Route::get('search', 'SearchController@search')->name('search'); // por enquanto search é uma pagina à parte, futuramente podemos mudar a home page consoante a pesquisa