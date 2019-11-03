<?php

Route::get('/', function () {
    return view('pages/index');
});

// Login Routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Admin - Playlist Routes
Route::get('/admin', 'Admin\PlaylistController@index')->name('admin.playlists.index');
Route::get('/admin/playlists', 'Admin\PlaylistController@create')->name('admin.playlists.create');
Route::post('/admin/playlists', 'Admin\PlaylistController@store')->name('admin.playlists.store');
Route::get('/admin/playlists/{id}/edit', 'Admin\PlaylistController@edit')->name('admin.playlists.edit');
Route::put('/admin/playlists/{id}', 'Admin\PlaylistController@update')->name('admin.playlists.update');
Route::delete('/admin/playlists/{id}', 'Admin\PlaylistController@destroy')->name('admin.playlists.destroy');

// Admin - Spotify Account Routes
Route::get('/admin/accounts', 'Admin\AccountController@index')->name('admin.accounts.index');
Route::get('/admin/accounts/create', 'Admin\AccountController@create')->name('admin.accounts.create');
Route::post('/admin/accounts', 'Admin\AccountController@store')->name('admin.accounts.store');
Route::get('/admin/accounts/{id}/edit', 'Admin\AccountController@edit')->name('admin.accounts.edit');
Route::put('/admin/accounts/{id}', 'Admin\AccountController@update')->name('admin.accounts.update');
Route::delete('/admin/accounts/{id}', 'Admin\AccountController@destroy')->name('admin.accounts.destroy');
