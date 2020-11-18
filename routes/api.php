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

//List users
Route::middleware('auth:api')->get('users', 'UserController@index')
    ->middleware('permissions:utilisateurs,consulter');
//Change user status
Route::middleware('auth:api')->post('user/change-status', 'UserController@changeStatus')
    ->middleware('permissions:utilisateurs,modifier');
//Reset user password
Route::middleware('auth:api')->post('user/reset-password', 'UserController@ajaxResetPassword')
    ->middleware('permissions:utilisateurs,modifier');
//Check if username exists
Route::middleware('auth:api')->get('user/unique-username/{username}', 'UserController@checkUsernameExists');
//Check if email exists
Route::middleware('auth:api')->get('user/unique-email/{email}', 'UserController@checkEmailExists');
//Select user
Route::middleware('auth:api')->get('user/{id}', 'UserController@selectUser')
    ->middleware('permissions:utilisateurs,consulter');
//Delete user
Route::middleware('auth:api')->delete('user/{user}', 'UserController@destroy')
    ->middleware('permissions:utilisateurs,supprimer');

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

/**** Modules ****/
Route::middleware('auth:api')->get('modules', 'ModuleController@index'); // Liste des modules;

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
Route::middleware('auth:api')->get('parametres/types-facture', 'TypeController@index');
    // ->middleware('permissions:chapitres,consulter'); // Liste des types de facture;
Route::middleware('auth:api')->post('parametres/types-facture', 'TypeController@store');
    // ->middleware('permissions:chapitres,creer'); // Ajouter un type de facture
Route::middleware('auth:api')->put('parametres/types-facture', 'TypeController@update');
    // ->middleware('permissions:chapitres,modifier'); // Modifier type de facture
Route::middleware('auth:api')->delete('parametres/types-facture/{type}', 'TypeController@destroy');
    // ->middleware('permissions:chapitres,supprimer'); //Suppression d'un chapitre

/***** Bordereau *****/
//Bordereau d'envoi des journees comptables
Route::middleware('auth:api')->get('bordereau/bejcs', 'BejcController@index')
    ->middleware('permissions:bejcs,consulter'); // Liste des bejcs;
Route::middleware('auth:api')->post('bordereau/bejcs', 'BejcController@store')
    ->middleware('permissions:bejcs,editer'); // Enregistrer bordereau;


/***** Documents *****/
Route::middleware('auth:api')->get('documents/bordereaux', 'BordereauController@index');
Route::middleware('auth:api')->post('documents/bordereaux', 'BordereauController@store');
Route::middleware('auth:api')->delete('documents/bordereaux/{upload}', 'BordereauController@destroy');

/***** Clients *****/
Route::middleware('auth:api')->get('clients', 'ClientController@index'); //Liste de clients
Route::middleware('auth:api')->post('clients', 'ClientController@store'); //Création d'un client
Route::middleware('auth:api')->get('clients/{client}', 'ClientController@showAjax'); //Sélection d'un client
Route::middleware('auth:api')->put('clients', 'ClientController@update'); //Modification des infos client
Route::middleware('auth:api')->delete('clients/{client}', 'ClientController@destroy'); //Suppression client

/***** Factures *****/
Route::middleware('auth:api')->get('factures', 'FactureController@index'); //Liste des facture
Route::middleware('auth:api')->post('factures', 'FactureController@store'); //Création d'une facture
Route::middleware('auth:api')->get('factures/{facture}', 'FactureController@getFacture'); //Sélection d'une facture
Route::middleware('auth:api')->patch('factures/{facture}', 'FactureController@update'); //Modification de la facture
Route::middleware('auth:api')->patch('factures/{facture}/validate', 'FactureController@validateFacture'); //Validation de la facture
Route::middleware('auth:api')->patch('factures/{facture}/cancel', 'FactureController@cancelFacture'); //Annuler la facture
// Route::middleware('auth:api')->delete('clients/{client}', 'ClientController@destroy'); //Suppression client

/***** Modes de paiement *****/
Route::middleware('auth:api')->get('modes-paiement', 'ModePaiementController@index'); //Liste des modes de paiement
Route::middleware('auth:api')->post('modes-paiement', 'ModePaiementController@store');
    // ->middleware('permissions:chapitres,creer'); // Ajouter un type de facture
Route::middleware('auth:api')->put('modes-paiement', 'ModePaiementController@update');
Route::middleware('auth:api')->delete('modes-paiement/{mode}', 'ModePaiementController@destroy');

/***** Liste des paiements *****/
Route::middleware('auth:api')->get('paiements', 'PaiementController@index'); //Liste des paiements
Route::middleware('auth:api')->post('paiements', 'PaiementController@store');

/***** API Personnel *****/
Route::get('/resources/villes', 'ApiController@getVilles'); //Liste de villes du gabon
Route::get('/resources/pays', 'ApiController@getPays'); //Liste des pays
