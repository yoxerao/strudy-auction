<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
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
//Route::get('cards', 'CardController@list');
//Route::get('cards/{id}', 'CardController@show');

// Auctions
Route::get('auction/create', 'AuctionController@createForm')->name('createAuctionForm');
Route::post('auction/create', 'AuctionController@create')->name('createAuction');
Route::get('auctions', 'AuctionController@list');
Route::get('auction/edit/{id}', 'AuctionController@editForm')->name('editAuctionForm');
Route::put('auction/edit/{id}', 'AuctionController@edit')->name('editAuction');
Route::delete('auction/delete/{id}', 'AuctionController@delete')->name('deleteAuction');
Route::get('auctions/{id}', 'AuctionController@show_my')->name('showMyAuction');

// Bid
Route::get('bid/makeBid/{id}', 'BidController@makeBidForm')->name('makeBidForm');
Route::post('bid/makeBid/{id}', 'BidController@makeBid')->name('makeBid');

// API
/*Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');*/

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
Route::get('search', 'SearchController@search')->name('search'); // por enquanto search é uma pagina à parte, futuramente podemos mudar a home page consoante a pesquisa

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', 'Admin\AdminAuthController@getLogin')->name('adminLogin');
    Route::post('/login', 'Admin\AdminAuthController@postLogin')->name('adminLoginPost');
    Route::get('{id}', 'Admin\AdminController@show')->name('adminProfile');


    Route::group(['middleware' => 'adminauth'], function () {
        Route::get('/', function () {
            return view('pages.adminHome')->with('users', User::all());
        })->name('adminDashboard');
    });
});

//listings
Route::get('user/{id}/bidding-history', 'UserController@biddingHistory')->name('biddingHistory');
Route::get('user/{id}/owned-auctions', 'UserController@ownedAuctions')->name('ownedAuctions');

//Payments
Route::get('user/{id}/deposit', 'DepositController@showForm')->name('depositForm')->middleware('auth');
/*Route::post('user/{id}/deposit', 'DepositController@processForm')->name('depositProcess');
Route::get('user/{id}/deposit/success', 'DepositController@success')->name('depositSuccess');
Route::get('user/{id}/deposit/cancel', 'DepositController@cancel')->name('depositCancel');*/


// Static Pages
Route::get('about', 'StaticPagesController@getAboutUs')->name('about');
Route::get('faq', 'StaticPagesController@getFaq')->name('faq');




//Route::get('erro')->name('Error');