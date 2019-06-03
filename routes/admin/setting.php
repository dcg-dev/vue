<?php

Route::group(['prefix' => 'settings'], function() {
    Route::post('/', 'SettingsController@store')->name('admin.settings.store');
    Route::get('notifications', 'SettingsController@notifications')->name('admin.settings.notifications');
    Route::get('sociality', 'SettingsController@sociality')->name('admin.settings.sociality');
    Route::get('billing', 'SettingsController@billing')->name('admin.settings.billing');
    Route::post('notifications/test', 'SettingsController@email')->name('admin.settings.email');
    Route::get('pagination', 'SettingsController@pagination')->name('admin.settings.pagination');
    Route::get('firewall', 'SettingsController@firewall')->name('admin.firewall');
});
