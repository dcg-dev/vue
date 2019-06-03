<?php

Route::group(['middleware' => ['web']], function() {

    Route::group(['prefix' => 'checkout'], function() {
        Route::get('/', 'CheckoutController@checkoutView')->name('checkout'); 
    });
    
    Route::group(['prefix' => 'api/checkout'], function() {
        Route::get('info', 'CheckoutController@checkoutInfo')->name('checkout.info');
        Route::post('complete', 'CheckoutController@complete')->name('checkout.complete');
        
        Route::group(['prefix' => 'item'], function() {
            Route::post('add', 'CheckoutController@addItem')->name('checkout.item.add');
            Route::delete('{item}', 'CheckoutController@removeItem')->name('checkout.item.remove');
        });
    });
    
});
