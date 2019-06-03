<?php

Route::group(['prefix' => 'order'], function() {
    Route::get('list', 'OrderController@viewList')->name('admin.order.list');
    Route::get('{order}/edit', 'OrderController@viewEdit')->name('admin.order.edit');
    Route::get('create', 'OrderController@viewCreate')->name('admin.order.create');
});

Route::group(['prefix' => 'api/order'], function() {
    Route::get('list', 'OrderController@getOrders');
    Route::delete('{order}', 'OrderController@deleteOrder');
    Route::post('create', 'OrderController@createOrder');
    Route::get('{order}', 'OrderController@getOrder');
    Route::post('{order}/update', 'OrderController@updateOrder');
});