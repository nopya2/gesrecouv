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

Route::redirect('/', '/portail');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/portail', 'HomeController@portail')->name('portail')->middleware('auth');
Route::get('/test', 'HomeController@test')->name('test');

/***** Statistics *****/
Route::get('/statistics', 'StatisticsController@home')->name('statistics')->middleware('auth')
    ->middleware('permissions:statistiques,consulter');

/***** Parametres *****/
Route::get('/parametres/chapitres', 'ChapitreController@home')->name('chapitres.index')->middleware('auth')
    ->middleware('permissions:chapitres,consulter');


/***** Documents *****/
Route::get('/documents/bordereaux', 'BordereauController@home')->name('bordereaux.index')->middleware('auth');


/***** Types de factures *****/
Route::get('/types-facture', 'TypeController@home')->name('types.index')->middleware('auth');

/***** Modes de paiement *****/
Route::get('/modes-paiement', 'ModePaiementController@home')->name('modes_paiement.index')->middleware('auth');

/***** Developers *****/
Route::get('/developers', 'DevelopersController@index');

/***** Modules *****/
Route::get('/modules', 'ModuleController@home')->name('modules.index')->middleware('auth');
    // ->middleware('permissions:groupes,consulter');

/***** Error page *****/
Route::get('/error', 'HomeController@error')->name('error')->middleware('auth');
    // ->middleware('permissions:groupes,consulter');
