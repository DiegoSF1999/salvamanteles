<?php

use Illuminate\Http\Request;

//          ->middleware('token');

            
            /////   Users   /////

Route::post('loginUser', 'UserController@login');

Route::post('createUser', 'UserController@store');

Route::get('getUsers', 'UserController@index')->middleware('token');

Route::post('recoverPassword', 'UserController@recover_password');

Route::post('changePassword', 'UserController@change_password')->middleware('token');

Route::get('restaurantToBBDD', 'RestaurantController@index');

Route::group(['middleware' => ['auth']], function () {
    //Route::post('showApps', 'ApplicationsController@showApps');
});