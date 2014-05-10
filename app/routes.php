<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::any('/login', 'UsersController@login');

Route::group(['before' => 'auth'], function() {
    Route::get('/', 'LogbooksController@dashboard');

    Route::resource('logbooks', 'LogbooksController');
    Route::resource('logbooks.entries', 'EntriesController');
    Route::resource('users', 'UsersController');

    Route::any('/logout', 'UsersController@logout');

    // Run the database migrations immediately
    Route::get('/migrate/do/now', function() {
	$status = Artisan::call('migrate');
	return var_dump($status);
    });
});
