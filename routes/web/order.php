<?php
Route::group(['middleware' => ['web', 'auth']], function() {

    Route::group(['prefix' => 'api/order', 'namespace' => 'Api'], function() {
        Route::get('list', 'OrderController@all');
        Route::get('counts', 'OrderController@counts');
        Route::get('purchased', 'OrderController@purchased');
        Route::get('billing', 'OrderController@billing');
    });
});