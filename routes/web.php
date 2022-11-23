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

// Auctions
Route::get('auction/create', 'AuctionController@createForm')->name('createAuctionForm');
Route::post('auction/create', 'AuctionController@create')->name('createAuction');
Route::get('auctions', 'AuctionController@list');
Route::get('auction/edit/{id}', 'AuctionController@editForm')->name('editAuctionForm');
Route::put('auction/edit/{id}', 'AuctionController@edit')->name('editAuction');
Route::delete('auction/delete/{id}', 'AuctionController@delete')->name('deleteAuction');

// Bid
Route::get('bid/makeBid/{id}', 'BidController@makeBidForm')->name('makeBidForm');
Route::post('bid/makeBid/{id}', 'BidController@makeBid')->name('makeBid');

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
Route::get('user/{id}/edit', 'UserController@info_edit')->name('editUser');
Route::put('user/{id}/edit', 'UserController@edit')->name('editProfile');
