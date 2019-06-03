<?php

Route::group(['middleware' => ['web']], function() {
    Route::get('items', 'ItemController@search')->name('items');
    Route::get('items/featured', 'ItemController@featured')->name('featured');
    Route::group(['prefix' => 'item'], function() {
        Route::get('{item}/download/demo', 'ItemController@downloadDemo')->name('item.download.demo');
        Route::group(['middleware' => ['auth']], function() {
            Route::get('favourites', 'ItemController@itemFavourites')->name('profile.item.favourites');
            Route::get('upload', 'ItemController@createView')->name('profile.item.upload');
            Route::group(['middleware' => ['can:update,item']], function() {
                Route::get('{item}/edit', 'ItemController@editView')->name('profile.item.edit');
            });
            Route::get('{slug}/download/product', 'ItemController@downloadProduct')->name('item.download.product');
        });
        Route::get('{item}', 'ItemController@view')->name('item');
    });
    Route::group(['prefix' => 'api/item'], function() {
        Route::get('list/featured', 'ItemController@featuredList');
        Route::get('list', 'ItemController@all');
        Route::get('max/{attribute}', 'ItemController@max');
        Route::group(['middleware' => ['auth']], function() {
            Route::post('affilate', 'ItemController@generateAffilateLink');
            Route::post('create', 'ItemController@create');
            Route::get('list/my', 'ItemController@my');
            Route::group(['middleware' => ['can:view,item']], function() {
                Route::post('{item}/favourite', 'ItemController@favourite');
                Route::post('{item}/commented', 'ItemController@commented');
            });
            Route::group(['middleware' => ['can:update,item']], function() {
                Route::post('{item}/edit', 'ItemController@update');
                Route::post('{item}/thumbnail', 'ItemController@thumbnail')->name('item.edit.thumbnail');
                Route::post('{item}/demo', 'ItemController@demo')->name('item.edit.demo');
                Route::post('{item}/product', 'ItemController@product')->name('item.edit.product');
                Route::post('{item}/publish', 'ItemController@publish')->name('item.edit.publish');
            });
        });
        Route::get('{item}', 'ItemController@get');
        Route::get('{item}/comments', 'ItemController@comments');
        Route::get('{item}/ratings', 'ItemController@ratings');
        Route::post('{item}/ratings', 'ItemController@addRating');
        Route::post('{id}/delete', 'ItemController@destroy');
    });
});



