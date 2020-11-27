<?php

/***** Liste des paiements *****/
Route::middleware('auth:api')->get('paiements', 'PaiementController@index'); //Liste des paiements
Route::middleware('auth:api')->post('paiements', 'PaiementController@store');
Route::middleware('auth:api')->patch('paiements/{paiement}/update-state', 'PaiementController@updateState'); //mise à jour de l'était du paiement