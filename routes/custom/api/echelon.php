<?php

//Selection des echelons par le numero d'engagement
Route::middleware('auth:api')->get('echelons/select-by-engagement-number', 'EchelonController@selectByEngagementNumber')
    ->middleware('permissions:paiements,consulter');
//Upload de fichiers pour les echelons
Route::middleware('auth:api')->post('echelon/upload-files', 'EchelonController@uploadFiles')
    ->middleware('permissions:paiements,modifier');

/****** Echelons ******/
//List echelons
Route::middleware('auth:api')->get('echelons', 'EchelonController@index')
    ->middleware('permissions:paiements,consulter');
//Ajouter un paiement
Route::middleware('auth:api')->post('echelon', 'EchelonController@store');
    // ->middleware('permissions:paiements,ajouter');
//Valider un paiement
Route::middleware('auth:api')->post('echelon/valider', 'EchelonController@validerPaiement')
    ->middleware('permissions:paiements,valider');
//Annuler un paiement
Route::middleware('auth:api')->post('echelon/annuler', 'EchelonController@annulerPaiement')
    ->middleware('permissions:paiements,annuler');