<?php

Route::group(['prefix' => 'format'], function() {
    Route::get('/', 'FormatController@index')->name('admin.format.list');
});

Route::group(['prefix' => 'api/format'], function() {
    Route::get('list', 'FormatController@formats');
    Route::post('store', 'FormatController@store');
    Route::post('sort', 'FormatController@sort');
    Route::delete('{format}', 'FormatController@delete');
});
