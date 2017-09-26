<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/playlists', 'PlaylistController@index');
Route::get('/playlists/{playlist}', 'PlaylistController@show');
Route::get('/search', 'TrackController@search');
