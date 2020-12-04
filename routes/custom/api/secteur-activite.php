<?php

/**** Modules ****/
Route::middleware('auth:api')->get('secteurs-activites', 'SecteurActiviteController@index'); // Liste des secteurs;
Route::middleware('auth:api')->post('secteurs-activites', 'SecteurActiviteController@store'); //Ajout d'un secteur
Route::middleware('auth:api')->patch('secteurs-activites', 'SecteurActiviteController@update'); // Modifier secteur
Route::middleware('auth:api')->delete('secteurs-activites/{secteur}', 'SecteurActiviteController@destroy'); //Suppression secteur