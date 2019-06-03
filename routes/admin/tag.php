<?php

Route::group(['prefix' => 'tag'], function() {
    Route::get('/', 'TagController@index')->name('admin.tag.list');
});

Route::group(['prefix' => 'api/tag'], function() {
    Route::get('list', 'TagController@tags');
    Route::post('create', 'TagController@create');
    Route::post('{tag}/update', 'TagController@update');
    Route::post('{tag}/delete', 'TagController@delete');
});
