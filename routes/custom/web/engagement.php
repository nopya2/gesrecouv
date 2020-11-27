<?php

/***** Engagemens *****/
Route::get('/engagements', 'EngagementController@home')->name('engagement.index')->middleware('auth')
    ->middleware('permissions:engagements,consulter');
Route::get('/engagements/{engagement}', 'EngagementController@show')->name('engagement.show')->middleware('auth')
    ->middleware('permissions:engagements,consulter');
Route::get('/search', 'EngagementController@search')->name('engagement.search')->middleware('auth')
    ->middleware('permissions:engagements,consulter');