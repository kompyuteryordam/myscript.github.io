<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'IndexController@index');
Route::get('/cart/{id}', 'IndexController@cart');
Route::get('/help', 'IndexController@help');
Route::get('/profile', 'IndexController@profile');
Route::get('/profile/partner', 'IndexController@profile_partner');
Route::get('/profile/finance', 'IndexController@profile_finance');
Route::get('/profile/partner/get-link', 'IndexController@link');
Route::get('/bonus', 'IndexController@bonus');
Route::get('/payout/available', 'IndexController@pavailable');
Route::get('/terms', 'IndexController@terms');
Route::get('/privacy', 'IndexController@privacy');
Route::get('/user/{id}', 'IndexController@user');
Route::get('/top100', 'IndexController@top100');
Route::get('/opinions', 'IndexController@opinions');

Route::post('/cart/open', 'IndexController@open');
Route::post('/cart/end', 'IndexController@tokta');
Route::post('/payment/in', 'IndexController@payment');
Route::post('/user/get-games', 'IndexController@get_games');
Route::post('/payout/payeer', 'IndexController@payeer');
Route::post('/payout/qiwi', 'IndexController@qiwi');
Route::post('/payout/yandex', 'IndexController@yandex');
Route::post('/api/lastOpen', 'IndexController@lastOpen');
Route::post('/api/users', 'IndexController@u_count');


Route::get('/login/vkontakte', 'LoginController@vklogin');
Route::get('/login/odnoklassniki', 'LoginController@oklogin');

Route::post('/checkpayment', 'IndexController@getpayment');
Route::get('/success', 'IndexController@success');




/*adminka*/
Route::group(['middleware' => 'auth', 'middleware' => 'access:admin'], function () {
	Route::get('/admin', ['as' => 'admin', 'uses' => 'AdminController@index']);
	/* Players */
	Route::get('/admin/users', ['as' => 'users', 'uses' => 'AdminController@users']);
	Route::post('/admin/user/save', ['as' => 'user.save', 'uses' => 'AdminController@user_save']);
	Route::get('/admin/user/{id}/edit', ['as' => 'user.edit', 'uses' => 'AdminController@edit_user']);
	Route::get('/admin/user/{id}/ban', 'AdminController@ban_user');
	/* Cases */
	Route::get('/admin/cases', ['as' => 'cases', 'uses' => 'AdminController@cases']);
	Route::get('/admin/new_case', ['as' => 'new_case', 'uses' => 'AdminController@new_case']);
	Route::get('/admin/case/{id}/edit', ['as' => 'case.edit', 'uses' => 'AdminController@case_edit']);
	Route::get('/admin/case/{id}/delete', ['as' => 'case.delete', 'uses' => 'AdminController@case_delete']);
	Route::get('/admin/item/{id}/add', ['as' => 'item.add', 'uses' => 'AdminController@item_add']);
	Route::get('/admin/item/{id}/edit', ['as' => 'item.edit', 'uses' => 'AdminController@item_edit']);
	Route::get('/admin/item/{id}/delete', ['as' => 'item.delete', 'uses' => 'AdminController@item_delete']);
	Route::post('/admin/item/add', ['as' => 'item.save', 'uses' => 'AdminController@item_create']);
	Route::post('/admin/item/update', ['as' => 'item.update', 'uses' => 'AdminController@item_update']);
	Route::post('/admin/case/save', ['as' => 'case.save', 'uses' => 'AdminController@add_case']);
	Route::post('/admin/case/update', ['as' => 'case.upd', 'uses' => 'AdminController@case_update']);
	/* Withdraw */
	Route::get('/admin/withdraw', ['as' => 'withdraw', 'uses' => 'AdminController@withdraw']);
	Route::post('/admin/withdraw/save', ['as' => 'withdraw.save', 'uses' => 'AdminController@withdraw_save']);
	Route::get('/admin/withdraw/{id}/edit', ['as' => 'withdraw.edit', 'uses' => 'AdminController@edit_withdraw']);
	/*Payments*/
	Route::get('/admin/payments', 'AdminController@payments');
	/*Settings*/
	Route::get('/admin/settings', 'AdminController@settings');
	Route::post('/admin/settings/save', 'AdminController@settings_save');
	/*OPINIONS*/
	Route::get('/admin/opinions', 'AdminController@opinions');
	Route::get('/admin/opinion/{id}/delete', 'AdminController@opinion_delete');
	Route::post('/admin/opinions/create', 'AdminController@opinion_create');
});
/*adminka*/


Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', 'LoginController@logout');
});