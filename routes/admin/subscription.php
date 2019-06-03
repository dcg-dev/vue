<?php

Route::group(['prefix' => 'subscription'], function() {
    Route::get('list', 'SubscriptionController@viewList')->name('admin.subscription.list');
});

Route::group(['prefix' => 'api/subscription'], function() {
    Route::get('list', 'SubscriptionController@getSubscriptions');
    Route::post('{subscription}/cancel', 'SubscriptionController@cancel');
});