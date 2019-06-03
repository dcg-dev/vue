<?php

Route::group(['prefix' => 'paypal'], function() {
    Route::get('success', 'PayPalController@success')->name('paypal.success');
    Route::get('cancel', 'PayPalController@cancel')->name('paypal.cancel');
    Route::post('ipn', 'PayPalController@ipn')->name('paypal.ipn');
});
