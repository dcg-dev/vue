<?php

Route::group(['middleware' => ['web']], function() {
    Route::get('collections/top', 'CollectionController@top')->name('collections.top');
    Route::group(['prefix' => 'collection'], function() {
        Route::get('{collection}', 'CollectionController@view')->name('collection');
    });

    Route::group(['prefix' => 'api/collection'], function() {
        Route::get('list', 'CollectionController@all');
        Route::get('{collection}', 'CollectionController@get');
        Route::get('{collection}/items', 'CollectionController@items');
        Route::group(['middleware' => ['auth']], function() {
            Route::post('create', 'CollectionController@create');
            Route::post('{collection}/save', 'CollectionController@update');
            Route::post('{collection}/follow', 'CollectionController@follow');
            Route::post('{collection}/attach', 'CollectionController@attach');//->middleware('can:attach,collection');
            Route::post('{collection}/detach', 'CollectionController@detach');//->middleware('can:detach,collection');
            Route::group(['middleware' => ['can:work,collection']], function() {
                Route::post('{collection}/delete', 'CollectionController@delete');
            });
        });
    });
});



