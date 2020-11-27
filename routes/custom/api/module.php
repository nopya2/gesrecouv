<?php

/**** Modules ****/
Route::middleware('auth:api')->get('modules', 'ModuleController@index'); // Liste des modules;
Route::middleware('auth:api')->post('modules', 'ModuleController@store'); //Ajout d'un module
Route::middleware('auth:api')->patch('modules', 'ModuleController@update'); // Modifier module
Route::middleware('auth:api')->delete('modules/{module}', 'ModuleController@destroy'); //Suppression module
Route::middleware('auth:api')->post('modules/{module}/add-permission', 'ModuleController@addPermission'); //Ajouter une permission au module
Route::middleware('auth:api')->delete('modules/{module}/delete-permission', 'ModuleController@deletePermission'); //supprimer une permission du module