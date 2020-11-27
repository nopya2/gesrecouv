<?php

/***** Users ****/
Route::get('/users', 'UserController@home')->name('user.index')->middleware('auth')
    ->middleware('permissions:utilisateurs,consulter');
Route::get('/user/create', 'UserController@create')->name('user.create')->middleware('auth')
    ->middleware('permissions:utilisateurs,creer');
Route::post('/user', 'UserController@store')->name('user.store')->middleware('auth')
    ->middleware('permissions:utilisateurs,creer');
Route::get('/user/{user}/edit', 'UserController@edit')->name('user.edit')->middleware('auth')
    ->middleware('permissions:utilisateurs,modifier');
Route::post('/user/{user}/edit', 'UserController@update')->name('user.update')->middleware('auth')
    ->middleware('permissions:utilisateurs,modifier');