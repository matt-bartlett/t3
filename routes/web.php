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

Route::get('/playlists', 'PlaylistController@index')->name('playlists.index');
Route::get('/playlists/{playlist}', 'PlaylistController@show')->name('playlists.show');
