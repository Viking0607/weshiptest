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

Route::get('/','ParcelController@checkProhibited');
Route::post('check_tracking', 'ParcelController@checkTracking');

Route::get('register_prohibited/{tn}', 'ParcelController@registerProhibited');

Route::post('create_prohibited', 'ParcelController@registerProhibitedForm');
