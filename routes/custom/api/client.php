<?php

/***** Clients *****/
Route::middleware('auth:api')->get('clients', 'ClientController@index'); //Liste de clients
Route::middleware('auth:api')->post('clients', 'ClientController@store'); //Création d'un client
Route::middleware('auth:api')->get('clients/{client}', 'ClientController@showAjax'); //Sélection d'un client
Route::middleware('auth:api')->put('clients', 'ClientController@update'); //Modification des infos client
Route::middleware('auth:api')->delete('clients/{client}', 'ClientController@destroy'); //Suppression client
//Liste des factures pour un client
Route::middleware('auth:api')->get('/clients/{client}/factures-client', 'ClientController@getFacturesByClient');