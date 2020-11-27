<?php

/***** Bordereau *****/
//Bordereau d'envoi des journees comptables
Route::middleware('auth:api')->get('bordereau/bejcs', 'BejcController@index')
    ->middleware('permissions:bejcs,consulter'); // Liste des bejcs;
Route::middleware('auth:api')->post('bordereau/bejcs', 'BejcController@store')
    ->middleware('permissions:bejcs,editer'); // Enregistrer bordereau;