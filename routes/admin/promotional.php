<?php

Route::group(['prefix' => 'promotional'], function() {
    Route::get('list', 'PromoSubscriptionController@viewList')->name('admin.promotional.list');
});

Route::group(['prefix' => 'api/promo-subscription'], function() {
    Route::get('list', 'PromoSubscriptionController@getSubscriptions');
    Route::post('{subscription}/cancel', 'PromoSubscriptionController@cancel');
});