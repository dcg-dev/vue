<?php

Route::group(['prefix' => 'oauth', 'namespace' => 'Auth'], function() {
    
    Route::group(['middleware' => ['auth']], function() {
        Route::get('stripe', 'StripeOauthController@redirectToProvider')->name('oauth.stripe');
        Route::get('stripe/callback', 'StripeOauthController@handleProviderCallback')->name('oauth.callback.stripe');
    });
    
    Route::group(['middleware' => ['guest']], function() {
        Route::get('{provider}', 'OauthController@redirectToProvider')->name('oauth');
        Route::get('{provider}/callback', 'OauthController@handleProviderCallback')->name('oauth.callback');
    });
});