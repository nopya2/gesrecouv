<?php

/***** Borderreau *****/
//Bordereau d'envoi des journees comptable
Route::get('/bordereau/bejcs', 'BejcController@home')->name('bejcs.index')->middleware('auth')
    ->middleware('permissions:bejcs,consulter');
Route::get('/bordereau/bejcs/create', 'BejcController@create')->name('bejc.create')->middleware('auth')
    ->middleware('permissions:bejcs,editer');
Route::get('/bordereau/bejcs/pdf/{bordereau}', 'BejcController@pdf')->name('bejc.pdf')
    ->middleware('permissions:bejcs,consulter');