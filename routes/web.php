<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('home');
//});

Route::redirect('/', '/home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/portail', 'HomeController@portail')->name('portail')->middleware('auth');
Route::get('/test', 'HomeController@test')->name('test');

/***** Users ****/
Route::get('/users', 'UserController@home')->name('user.index')->middleware('auth')
    ->middleware('permissions:utilisateurs,consulter');
Route::get('/user/create', 'UserController@create')->name('user.create')->middleware('auth')
    ->middleware('permissions:utilisateurs,creer');
Route::post('/user', 'UserController@store')->name('user.store')->middleware('auth')
    ->middleware('permissions:utilisateurs,creer');
Route::get('/user/{user}/edit', 'UserController@edit')->name('user.edit')->middleware('auth')
    ->middleware('permissions:utilisateurs,modifier');
Route::post('/user/{user}/edit', 'UserController@update')->name('user.update')->middleware('auth')
    ->middleware('permissions:utilisateurs,modifier');

/***** Groups *****/
Route::get('/groups', 'GroupController@home')->name('groups.index')->middleware('auth')
    ->middleware('permissions:groupes,consulter');
Route::get('/groups/{group}/permissions', 'GroupController@permissions')->name('groups.permissions')->middleware('auth')
    ->middleware('permissions:groupes,modifier');


/***** Engagemens *****/
Route::get('/engagements', 'EngagementController@home')->name('engagement.index')->middleware('auth')
    ->middleware('permissions:engagements,consulter');
Route::get('/engagements/{engagement}', 'EngagementController@show')->name('engagement.show')->middleware('auth')
    ->middleware('permissions:engagements,consulter');
Route::get('/search', 'EngagementController@search')->name('engagement.search')->middleware('auth')
    ->middleware('permissions:engagements,consulter');

/***** Echelons ****/
Route::get('/echelons', 'EchelonController@home')->name('echelon.index')->middleware('auth')
    ->middleware('permissions:paiements,consulter');
Route::get('/uploads/documents/{document}', 'EchelonController@showAttacheFile')->middleware('auth');

/***** Providers *****/
Route::get('/providers', 'ProviderController@home')->name('provider.index')->middleware('auth')
    ->middleware('permissions:fournisseurs,consulter');
Route::get('/providers/provider-pdf', 'ProviderController@printPDF')->name('provider.pdf')->middleware('auth')
    ->middleware('permissions:fournisseurs,exporter');
Route::get('/providers/history', 'ProviderController@history')->name('provider.history.pdf')->middleware('auth')
    ->middleware('permissions:fournisseurs,consulter');
Route::get('/providers/export', 'ProviderController@exportProviders')->name('export');
Route::get('/providers/pdf/situation-fournisseurs', 'ProviderController@printProviders')->name('print_providers');

/***** Statistics *****/
Route::get('/statistics', 'StatisticsController@home')->name('statistics')->middleware('auth')
    ->middleware('permissions:statistiques,consulter');

/***** Parametres *****/
Route::get('/parametres/chapitres', 'ChapitreController@home')->name('chapitres.index')->middleware('auth')
    ->middleware('permissions:chapitres,consulter');

/***** Borderreau *****/
//Bordereau d'envoi des journees comptable
Route::get('/bordereau/bejcs', 'BejcController@home')->name('bejcs.index')->middleware('auth')
    ->middleware('permissions:bejcs,consulter');
Route::get('/bordereau/bejcs/create', 'BejcController@create')->name('bejc.create')->middleware('auth')
    ->middleware('permissions:bejcs,editer');
Route::get('/bordereau/bejcs/pdf/{bordereau}', 'BejcController@pdf')->name('bejc.pdf')
    ->middleware('permissions:bejcs,consulter');


/***** Documents *****/
Route::get('/documents/bordereaux', 'BordereauController@home')->name('bordereaux.index')->middleware('auth');

/***** Clients *****/
Route::get('/clients', 'ClientController@home')->name('clients.index')->middleware('auth');
    // ->middleware('permissions:engagements,consulter');
Route::get('/clients/create', 'ClientController@create')->name('clients.create')->middleware('auth');
Route::get('/clients/{client}/edit', 'ClientController@edit')->name('client.edit')->middleware('auth');
Route::get('/clients/{client}', 'ClientController@show')->name('client.show')->middleware('auth');

/***** Factures *****/
Route::get('/factures', 'FactureController@home')->name('factures.index')->middleware('auth');
    // ->middleware('permissions:engagements,consulter');
Route::get('/factures/create', 'FactureController@create')->name('factures.create')->middleware('auth');
// Route::get('/clients/{client}/edit', 'ClientController@edit')->name('client.edit')->middleware('auth');
Route::get('/factures/{facture}', 'FactureController@show')->name('facture.show')->middleware('auth');

/***** Types de factures *****/
Route::get('/types-facture', 'TypeController@home')->name('types.index')->middleware('auth');

/***** Modes de paiement *****/
Route::get('/modes-paiement', 'ModePaiementController@home')->name('modes_paiement.index')->middleware('auth');

/***** Developers *****/
Route::get('/developers', 'DevelopersController@index');
