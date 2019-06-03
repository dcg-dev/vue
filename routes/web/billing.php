<?php

Route::group(['middleware' => ['web']], function() {
    Route::group(['prefix' => 'api/billing'], function() {
            Route::group(['prefix' => 'plan'], function() {
                Route::get('list', 'BillingController@plans');
                Route::get('promo', 'BillingController@promoPlans');
            });
        });
    Route::group(['middleware' => ['auth']], function() {
        Route::group(['prefix' => 'api/billing'], function() {
            Route::group(['prefix' => 'plan'], function() {
                Route::post('{id}/subscribe', 'BillingController@subscribe')->name('billing.subscription.subscribe');
                Route::get('{plan}/available-subscribe', 'BillingController@availableSubscribe');
            });
            Route::get('invoices', 'BillingController@invoices')->name('billing.invoices');
            Route::post('renewal-subscription', 'BillingController@renewalSubscription');
        });

        Route::group(['prefix' => 'api/promo-plan'], function() {
            Route::post('{plan}/buy', 'BillingController@buyPromo');
        });

        Route::group(['prefix' => 'billing'], function() {
            Route::group(['prefix' => 'subscription'], function() {
                Route::get('upgrade', 'BillingController@upgrade')->name('billing.subscription.upgrade');
                Route::get('upgrade/{plan}', 'BillingController@view')->name('billing.subscription.view');
            });
            Route::get('invoice/{order}', 'BillingController@invoice')->name('billing.invoice');

            Route::get('paypal', 'BillingController@paypal');
        });
    });
});
