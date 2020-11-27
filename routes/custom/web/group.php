<?php

/***** Groups *****/
Route::get('/groups', 'GroupController@home')->name('groups.index')->middleware('auth')
    ->middleware('permissions:groupes,consulter');
Route::get('/groups/{group}/permissions', 'GroupController@permissions')->name('groups.permissions')->middleware('auth')
    ->middleware('permissions:groupes,modifier');