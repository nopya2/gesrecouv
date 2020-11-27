<?php

/**** Groups ****/
Route::middleware('auth:api')->get('groups', 'GroupController@index')
    ->middleware('permissions:groupes,consulter'); // Liste des groupes;
Route::middleware('auth:api')->post('groups', 'GroupController@store')
    ->middleware('permissions:groupes,creer'); // Créer un groupe
Route::middleware('auth:api')->put('groups', 'GroupController@update')
    ->middleware('permissions:groupes,modifier'); // Modifier groupe
Route::middleware('auth:api')->delete('groups/{group}', 'GroupController@destroy')
    ->middleware('permissions:groupes,supprimer'); //Suppression d'un groupe
Route::middleware('auth:api')->get('groups/{group}', 'GroupController@ajaxShow')
    ->middleware('permissions:groupes,consulter'); //Selectionner un groupe
Route::post('groups/{group}/permission-change/{permission}', 'GroupController@changePermission');// Modifier les permissions