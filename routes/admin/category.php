<?php
Route::get('categories', 'CategoryController@index')->name('admin.category.list');
Route::group(['prefix' => 'api/category'], function() {
    Route::get('list', 'CategoryController@all');
    Route::post('store', 'CategoryController@store');
    Route::delete('{category}', 'CategoryController@delete');
});