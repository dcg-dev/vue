<?php

Route::group(['middleware' => ['web', 'auth']], function() {
    Route::group(['prefix' => 'api/license'], function() {
        Route::get('all', 'LicenseController@all');
    });
});



