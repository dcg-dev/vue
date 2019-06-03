<?php

Route::group(['middleware' => ['web', 'auth']], function() {

    Route::group(['prefix' => 'profile'], function() {
        Route::get('/affiliate/sales', 'AffiliateController@sales')->name('profile.affiliate.sales');
        Route::get('/affiliate/link', 'AffiliateController@link')->name('profile.affiliate.link');
    });
    
    
    Route::group(['prefix' => 'api/affiliate'], function() {
        Route::get('list', 'AffiliateController@my');
        Route::get('info', 'AffiliateController@info');
        Route::post('request', 'AffiliateController@request');
    });
});
