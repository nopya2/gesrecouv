<?php

/***** Providers *****/
Route::get('/providers', 'ProviderController@home')->name('provider.index')->middleware('auth')
    ->middleware('permissions:fournisseurs,consulter');
Route::get('/providers/provider-pdf', 'ProviderController@printPDF')->name('provider.pdf')->middleware('auth')
    ->middleware('permissions:fournisseurs,exporter');
Route::get('/providers/history', 'ProviderController@history')->name('provider.history.pdf')->middleware('auth')
    ->middleware('permissions:fournisseurs,consulter');
Route::get('/providers/export', 'ProviderController@exportProviders')->name('export');
Route::get('/providers/pdf/situation-fournisseurs', 'ProviderController@printProviders')->name('print_providers');