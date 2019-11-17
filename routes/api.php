<?php

Route::get('/playlists', 'PlaylistController@index');
Route::get('/playlists/{playlist}', 'PlaylistController@show');
Route::get('/search', 'TrackController@search');
Route::get('/stats', 'StatsController@index');
