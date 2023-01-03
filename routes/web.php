<?php

use App\Models\Report;
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
Route::get('auction/create', 'AuctionController@createForm')->name('createAuctionForm')->middleware('auth');
Route::post('auction/create', 'AuctionController@create')->name('createAuction');
Route::get('auctions', 'AuctionController@list');
Route::get('auction/edit/{id}', 'AuctionController@editForm')->name('editAuctionForm')->middleware('auth');
Route::put('auction/edit/{id}', 'AuctionController@edit')->name('editAuction');
Route::delete('auction/delete/{id}', 'AuctionController@delete')->name('deleteAuction')->middleware('auth');
Route::get('auctions/{id}', 'AuctionController@show_my')->name('showMyAuction');
Route::post('auction/{id}/bid/delete', 'BidController@deleteHighestBid')->name('deleteBid');
Route::post('auction/{id}/follow', 'UserFollowAuctionController@follow')->name('followAuction');
Route::get('auction/followers/{id}', 'UserFollowAuctionController@list');

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
Route::get('user/{id}/edit', 'UserController@info_edit')->name('editUser')->middleware('auth'); // ! IMPORTANTE CRIAR POLICY PARA IMPEDIR EDIT SE NAO FOR AUTENTICADO OU ADMIN
Route::put('user/{id}/edit', 'UserController@edit')->name('editProfile');
Route::get('user/{id}/editpass', 'UserController@info_edit_pass')->name('editPass_info')->middleware('auth');
Route::put('user/{id}/editpass', 'UserController@edit_pass')->name('editPass'); // ! IMPORTANTE CRIAR POLICY PARA IMPEDIR EDIT SE NAO FOR AUTENTICADO
Route::get('user/{id}/report', 'UserController@reportForm')->name('reportUserForm')->middleware('auth');
Route::post('user/{id}/report', 'UserController@reportPost')->name('reportUserPost');

//Admin
Route::get('search', 'SearchController@search')->name('search'); // por enquanto search é uma pagina à parte, futuramente podemos mudar a home page consoante a pesquisa

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', 'Admin\AdminAuthController@getLogin')->name('adminLogin');
    Route::post('login', 'Admin\AdminAuthController@postLogin')->name('adminLoginPost');
    Route::get('{id}', 'Admin\AdminController@show')->name('adminProfile');
    Route::post('validation', 'Admin\ValidationController@validateBan')->name('validateBan');

    Route::group(['middleware' => 'adminauth'], function () {
        Route::get('/', function () {
            return view('pages.adminHome')->with('reports', Report::doesntHave('validation')->get());
        })->name('adminDashboard');
    });
});



//listings
Route::get('user/{id}/bidding-history', 'UserController@biddingHistory')->name('biddingHistory');
Route::get('user/{id}/owned-auctions', 'UserController@ownedAuctions')->name('ownedAuctions');


// Static Pages
Route::get('about', 'StaticPagesController@getAboutUs')->name('about');
Route::get('faq', 'StaticPagesController@getFaq')->name('faq');




//Route::get('erro')->name('Error');