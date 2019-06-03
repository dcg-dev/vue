<?php
Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('feed', 'UserController@feed')->name('feed');
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/items', 'ItemController@listView')->name('profile.my.items');
        Route::get('/edit', 'ProfileController@edit')->name('profile.edit');
        Route::get('/settings', 'ProfileController@settings')->name('profile.settings');
        Route::get('/notifications', 'ProfileController@notifications')->name('profile.notifications');
        Route::get('/dashboard', 'ProfileController@dashboard')->name('profile.dashboard');
        Route::get('/inbox', 'ProfileController@inbox')->name('profile.inbox');
        Route::get('/inbox/compose', 'ProfileController@compose')->name('profile.inbox.compose');
        Route::get('/subscriptions', 'ProfileController@subscriptions')->name('profile.subscriptions');
        Route::get('/sales', 'ProfileController@sales')->name('profile.sales');
        Route::get('/downloads', 'ProfileController@downloads')->name('profile.downloads');
        Route::get('/promotions', 'ProfileController@promotions')->name('profile.promotions');
    });

    Route::group(['prefix' => 'api/profile'], function () {
        Route::post('/update', 'ProfileController@update')->name('profile.update');
        Route::post('/update/intersect', 'ProfileController@updateProfile')->name('profile.update.intersect');
        Route::post('/updateSettings', 'ProfileController@updateSettings')->name('profile.updateSettings');
        Route::get('/current', 'ProfileController@current')->name('profile.current');
        Route::get('/notifications', 'ProfileController@getNotifications')->name('profile.getNotifications');
        Route::post('/flushNotifications', 'ProfileController@flushNotifications')->name('profile.flushNotifications');
        Route::get('/dashboard', 'ProfileController@getDashboard')->name('profile.getDashboard');
        Route::get('/statistics/{type}', 'ProfileController@getStatistics')->name('profile.getStatistics');
        Route::get('/subscriptions', 'ProfileController@subscriptions')->name('profile.getSubscriptions');
        Route::get('/dashboard/visitors', 'ProfileController@visitors')->name('profile.dashboard.visitors');
        Route::get('/dashboard/processed-sales', 'ProfileController@processedSales')->name('profile.dashboard.sale.processed');
        Route::get('/dashboard/earnings', 'ProfileController@earnings')->name('profile.dashboard.earnings');
        Route::get('/dashboard/average-sale', 'ProfileController@averageSale')->name('profile.dashboard.sale.average');
    });
});