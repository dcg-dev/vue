<?php

Route::group(['prefix' => 'item'], function () {
    Route::get('list', 'ItemController@items')->name('admin.item.list');
    Route::get('{item}/edit', 'ItemController@viewEdit')->name('admin.item.edit');
    Route::get('create', 'ItemController@viewCreate')->name('admin.item.create');
});
Route::group(['prefix' => 'api/item'], function () {
    Route::get('list', 'ItemController@getItems');
    Route::post('{item}/approve', 'ItemController@approve');
    Route::post('{item}/decline', 'ItemController@decline');
    Route::delete('{item}', 'ItemController@delete');
    Route::post('create', 'ItemController@create');
    Route::post('{item}/update', 'ItemController@update');
    Route::post('{item}/thumbnail', 'ItemController@uploadThumbnail')->name('admin.item.thumbnail');
    Route::post('{item}/demo', 'ItemController@uploadDemo')->name('admin.item.demo');
    Route::post('{item}/product', 'ItemController@uploadProduct')->name('admin.item.product');
});

Route::group(['prefix' => 'comment'], function () {
    Route::get('list', 'ItemController@comments')->name('admin.comment.list');
});
Route::group(['prefix' => 'api/comment'], function () {
    Route::get('list', 'ItemController@getComments');
    Route::delete('{comment}', 'ItemController@deleteComment');
    Route::post('{comment}', 'ItemController@updateComment');
});

Route::group(['prefix' => 'rating'], function () {
    Route::get('list', 'ItemController@ratings')->name('admin.rating.list');
});
Route::group(['prefix' => 'api/rating'], function () {
    Route::get('list', 'ItemController@getRatings');
    Route::delete('{rating}', 'ItemController@deleteRating');
    Route::post('{rating}', 'ItemController@updateRating');
});