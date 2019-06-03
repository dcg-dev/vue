<?php

Route::group(['middleware' => ['web']], function() {
    Route::group(['prefix' => 'category'], function() {
        Route::get('{category}', 'CategoryController@view')->name('category');
    });
    Route::group(['prefix' => 'api/category'], function() {
        Route::get('list', 'CategoryController@all');
        Route::get('list/select', 'CategoryController@select');
    });
});
