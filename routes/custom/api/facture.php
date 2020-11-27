<?php

/***** Factures *****/
Route::middleware('auth:api')->get('factures', 'FactureController@index'); //Liste des facture
Route::middleware('auth:api')->post('factures', 'FactureController@store'); //Création d'une facture
Route::middleware('auth:api')->get('factures/{facture}', 'FactureController@getFacture'); //Sélection d'une facture
Route::middleware('auth:api')->patch('factures/{facture}', 'FactureController@update'); //Modification de la facture
Route::middleware('auth:api')->patch('factures/{facture}/validate', 'FactureController@validateFacture'); //Validation de la facture
Route::middleware('auth:api')->patch('factures/{facture}/cancel', 'FactureController@cancelFacture'); //Annuler la facture
Route::middleware('auth:api')->patch('factures/{facture}/litigate', 'FactureController@litigateFacture'); //Modifie le statut de la facture en litige
Route::middleware('auth:api')->patch('factures/{facture}/make-credit-note', 'FactureController@transformToCreditNote'); //Transformer facture en avoir
Route::middleware('auth:api')->post('factures/{facture}/add-document', 'FactureController@addDocument'); //Ajouter document à la facture
Route::middleware('auth:api')->delete('factures/{facture}/remove-document', 'FactureController@removeDocument'); //Supprimer document d'une facture
Route::middleware('auth:api')->delete('factures/{facture}', 'FactureController@destroy'); //Suppression de la facture