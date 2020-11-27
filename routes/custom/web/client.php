<?php

/***** Clients *****/
Route::get('/clients', 'ClientController@home')->name('clients.index')->middleware('auth');
    // ->middleware('permissions:engagements,consulter');
Route::get('/clients/create', 'ClientController@create')->name('clients.create')->middleware('auth');
Route::get('/clients/{client}/edit', 'ClientController@edit')->name('client.edit')->middleware('auth');
Route::get('/clients/{client}', 'ClientController@show')->name('client.show')->middleware('auth');