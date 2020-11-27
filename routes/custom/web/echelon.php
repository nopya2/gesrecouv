<?php

/***** Echelons ****/
Route::get('/echelons', 'EchelonController@home')->name('echelon.index')->middleware('auth')
    ->middleware('permissions:paiements,consulter');
Route::get('/uploads/documents/{document}', 'EchelonController@showAttacheFile')->middleware('auth');