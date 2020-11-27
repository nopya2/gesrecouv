<?php

//List engagements
Route::middleware('auth:api')->get('engagements', 'EngagementController@index')
    ->middleware('permissions:engagements,consulter');
//Recherche des engagements par la méthode post
Route::middleware('auth:api')->post('engagements/search', 'EngagementController@searchPost')
    ->middleware('permissions:engagements,consulter');
//Selectionner un engagement
Route::middleware('auth:api')->get('engagements/{engagement}', 'EngagementController@ajaxSelectSingle')
    ->middleware('permissions:engagements,consulter');
//Import fichier engagements
Route::middleware('auth:api')->post('engagements/import', 'EngagementController@import')
    ->middleware('permissions:engagements,importer');
//Select engagements par statut
Route::middleware('auth:api')->get('engagements/ajax/engagements-par-statut', 'EngagementController@engagementsParStatut')
    ->middleware('permissions:engagements,consulter');
//nbre engagements par annee
Route::middleware('auth:api')->get('engagements/ajax/engagements-par-annee', 'EngagementController@engagementsParAnnee')
    ->middleware('permissions:engagements,consulter');
//montant total par annee
Route::middleware('auth:api')->get('engagements/ajax/montants-par-annee', 'EngagementController@montantParAnnee')
    ->middleware('permissions:engagements,consulter');
//Selection des engagements par filtre multi criteres
Route::middleware('auth:api')->get('search', 'EngagementController@engagementsByMutlicriteria')
    ->middleware('permissions:engagements,consulter');
//Liste nature des listNaturesDepenses
Route::middleware('auth:api')->get('nature-depense', 'EngagementController@listNaturesDepenses')
    ->middleware('permissions:engagements,consulter');
//Chargements des données pour le filtre multicritères
Route::middleware('auth:api')->get('engagements/search/criteres', 'EngagementController@loadCriterias')
    ->middleware('permissions:engagements,consulter');
Route::middleware('auth:api')->put('engagements', 'EngagementController@update')
    ->middleware('permissions:engagements,modifier'); //Modifier informations engagements
//Selection des engagements pour les input field
Route::middleware('auth:api')->get('engagements/ajax/input-fields', 'EngagementController@selectEngagementsForInputField')
    ->middleware('permissions:engagements,consulter');
//Annuler engagement
Route::middleware('auth:api')->put('engagements/cancel', 'EngagementController@cancel')
    ->middleware('permissions:engagements,modifier');