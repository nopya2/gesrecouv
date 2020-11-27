<?php

/***** Factures *****/
Route::get('/factures', 'FactureController@home')->name('factures.index')->middleware('auth');
    // ->middleware('permissions:engagements,consulter');
Route::get('/factures/create', 'FactureController@create')->name('factures.create')->middleware('auth');
// Route::get('/clients/{client}/edit', 'ClientController@edit')->name('client.edit')->middleware('auth');
Route::get('/factures/{facture}', 'FactureController@show')->name('facture.show')->middleware('auth');
Route::get('/factures/{facture}/edit', 'FactureController@edit')->name('facture.edit')->middleware('auth');