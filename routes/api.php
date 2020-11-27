<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/oauth', 'UserController@apiLogin');

/***** Statistiques *****/
Route::middleware('auth:api')->get('statistics/engagements-annee', 'StatisticsController@engagementsAnnee');
Route::middleware('auth:api')->get('statistics/montants-engages-annee', 'StatisticsController@montantsEngagesAnnee');
Route::middleware('auth:api')->get('statistics/engagements-statut-annee', 'StatisticsController@engagementsStatutAnnee');

/**** Parametres/Chapitres ****/
Route::middleware('auth:api')->get('parametres/chapitres', 'ChapitreController@index')
    ->middleware('permissions:chapitres,consulter'); // Liste des chapitres;
Route::middleware('auth:api')->post('parametres/chapitres', 'ChapitreController@store')
    ->middleware('permissions:chapitres,creer'); // Ajouter un chapitre
Route::middleware('auth:api')->put('parametres/chapitres', 'ChapitreController@update')
    ->middleware('permissions:chapitres,modifier'); // Modifier chapitre
Route::middleware('auth:api')->delete('parametres/chapitres/{chapitre}', 'ChapitreController@destroy')
    ->middleware('permissions:chapitres,supprimer'); //Suppression d'un chapitre

/**** Parametres/Types ****/
Route::middleware('auth:api')->get('types-facture', 'TypeController@index');
    // ->middleware('permissions:chapitres,consulter'); // Liste des types de facture;
Route::middleware('auth:api')->post('types-facture', 'TypeController@store');
    // ->middleware('permissions:chapitres,creer'); // Ajouter un type de facture
Route::middleware('auth:api')->put('types-facture', 'TypeController@update');
    // ->middleware('permissions:chapitres,modifier'); // Modifier type de facture
Route::middleware('auth:api')->delete('types-facture/{type}', 'TypeController@destroy');
    // ->middleware('permissions:chapitres,supprimer'); //Suppression d'un chapitre

/***** Documents *****/
Route::middleware('auth:api')->get('documents/bordereaux', 'BordereauController@index');
Route::middleware('auth:api')->post('documents/bordereaux', 'BordereauController@store');
Route::middleware('auth:api')->delete('documents/bordereaux/{upload}', 'BordereauController@destroy');


/***** Modes de paiement *****/
Route::middleware('auth:api')->get('modes-paiement', 'ModePaiementController@index'); //Liste des modes de paiement
Route::middleware('auth:api')->post('modes-paiement', 'ModePaiementController@store');
    // ->middleware('permissions:chapitres,creer'); // Ajouter un type de facture
Route::middleware('auth:api')->put('modes-paiement', 'ModePaiementController@update');
Route::middleware('auth:api')->delete('modes-paiement/{mode}', 'ModePaiementController@destroy'); 

/***** API Personnel *****/
Route::get('/resources/villes', 'ApiController@getVilles'); //Liste de villes du gabon
Route::get('/resources/pays', 'ApiController@getPays'); //Liste des pays
