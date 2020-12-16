<?php

Route::middleware('auth:api')->delete('relaunches/{relaunch}', 'RelaunchController@destroy'); // Suppression d'une relance;