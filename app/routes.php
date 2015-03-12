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

/* Routes for signing custody */
Route::get('/custody/{id}/signature/{hash}', 'CustodyController@signature');
Route::post('/custody/{id}/signature/{hash}/update', [ 'as' => 'custodySignatureUpdate', 'uses' => 'CustodyController@signatureUpdate' ]);
Route::get('/custody/{id}/return/{hash}', 'CustodyController@returned');
Route::post('/custody/{id}/return/{hash}/update', [ 'as' => 'custodyReturnUpdate', 'uses' => 'CustodyController@returnedUpdate' ]);
/* End routes signing custody */

Route::any('/login', 'UsersController@login');

Route::group(['before' => 'auth'], function() {
    Route::get('/', 'EntriesController@index');
    Route::get('/intro', 'DashboardController@intro');

    Route::resource('logbooks', 'LogbooksController');
    Route::resource('logbooks.entries', 'EntriesController');

    Route::get('/entries', 'EntriesController@index');

    Route::resource('settings', 'SettingsController');
    Route::resource('suspects', 'SuspectsController');
    Route::resource('users', 'UsersController');
    Route::resource('tasks', 'TasksController');
    Route::resource('evidences', 'EvidenceController');
    Route::resource('attachments', 'AttachmentsController');
    Route::resource('legals', 'LegalsController');
    Route::resource('custody', 'CustodyController');

    Route::get('/custody/{id}/sign', 'CustodyController@sign');
    Route::post('/custody/{id}/sign/update', [ 'as' => 'custodySignUpdate', 'uses' => 'CustodyController@signUpdate' ]);
    Route::get('/custody/{id}/log', 'CustodyController@log');
    Route::post('/custody/{id}/log/update', [ 'as' => 'custodyLogUpdate', 'uses' => 'CustodyController@logUpdate' ]);

    Route::get('/attachment/{id}/download', 'AttachmentsController@download');
    Route::post('/attachment/upload', 'AttachmentsController@upload');

    Route::post('/tasks/{id}/toggle', 'TasksController@toggle');

    Route::get('/exports', 'ExportsController@index');
    Route::get('/exports/create/{type}', 'ExportsController@create');
    Route::delete('/exports/{export_id}', 'ExportsController@destroy');

    Route::any('/logout', 'UsersController@logout');

    Route::get('/cipher', 'DashboardController@cipher_tool');

    Route::get('/phpinfo', function() {
	    phpinfo();
    });
});
