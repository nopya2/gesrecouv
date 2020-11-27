<?php

/****** Providers ******/
//List providers
Route::middleware('auth:api')->get('providers', 'ProviderController@index')
    ->middleware('permissions:fournisseurs,consulter');
//On charge les informations du fournisseur
Route::middleware('auth:api')->get('providers/details', 'ProviderController@loadData')
    ->middleware('permissions:fournisseurs,consulter');
//On charge les engagements du fournisseur
Route::middleware('auth:api')->get('provider/engagements', 'ProviderController@loadEngagements')
    ->middleware('permissions:fournisseurs,consulter');
//On charge les echelons du fournisseur
Route::middleware('auth:api')->get('provider/echelons', 'ProviderController@loadEchelons')
    ->middleware('permissions:fournisseurs,consulter');