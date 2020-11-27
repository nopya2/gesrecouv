
<?php

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