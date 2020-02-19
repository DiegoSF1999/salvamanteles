<?php

use Illuminate\Http\Request;

//          ->middleware('token');

            
            /////   Users   /////

Route::post('loginUser', 'UserController@login');

Route::post('createUser', 'UserController@store');

Route::get('getUsers', 'UserController@index')->middleware('token');

Route::post('recoverPassword', 'UserController@recover_password');

Route::post('changePassword', 'UserController@change_password')->middleware('token');

Route::post('removeUser', 'UserController@remove')->middleware('token');


            /////   Profiles/Comensales   /////


Route::post('getAllProfiles', 'ProfileController@index')->middleware('token');

Route::post('removeProfile', 'ProfileController@remove')->middleware('token');

Route::post('createProfile', 'ProfileController@store')->middleware('token');

Route::post('renameProfile', 'ProfileController@rename')->middleware('token');

Route::post('removeIngredientFromProfile', 'ProfileController@remove_ingredient')->middleware('token');

Route::post('assignIngredientToProfile', 'ProfileController@assign_ingredient')->middleware('token');


Route::get('restaurantToBBDD', 'RestaurantController@index');

Route::group(['middleware' => ['auth']], function () {
    //Route::post('showApps', 'ApplicationsController@showApps');
});