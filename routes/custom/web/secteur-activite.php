<?php

/***** List des secteurs d'activité *****/
Route::get('/secteurs-activites', 'SecteurActiviteController@home')->name('secteurs_activites.index')->middleware('auth');