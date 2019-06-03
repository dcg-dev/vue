<?php

Route::group(['prefix' => 'billing'], function() {
    Route::get('plans', 'BillingController@plansSearch')->name('admin.billing.plan.list');
    Route::get('promo-plans', 'PromoPlanController@index')->name('admin.billing.promo-plan.index');
    Route::group(['prefix' => 'item'], function() {
        Route::get('requests', 'ItemController@index')->name('admin.item.requests');
    });
});

Route::group(['prefix' => 'api/billing'], function() {
    Route::get('list', 'BillingController@plans');
    Route::group(['prefix' => 'plan'], function() {
        Route::get('list', 'BillingController@plans');
        Route::post('create', 'BillingController@create');
        Route::post('{plan}/update', 'BillingController@update');
        Route::post('{plan}/delete', 'BillingController@delete');
    });
});

Route::group(['prefix' => 'api/promo-plan'], function() {
    Route::get('list', 'PromoPlanController@plans');
    Route::post('create', 'PromoPlanController@create');
    Route::post('{plan}/update', 'PromoPlanController@update');
    Route::post('{plan}/delete', 'PromoPlanController@delete');
});
