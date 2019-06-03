<?php

Route::group(['middleware' => ['web']], function() {
    Route::group(['prefix' => 'api/format'], function() {
        Route::get('all', 'FormatController@all');
    });
});



