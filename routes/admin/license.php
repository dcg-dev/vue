<?php

Route::group(['prefix' => 'license'], function() {
    Route::get('/', 'LicenseController@index')->name('admin.license.list');
});

Route::group(['prefix' => 'api/license'], function() {
    Route::get('list', 'LicenseController@licenses');
    Route::post('store', 'LicenseController@store');
    Route::post('sort', 'LicenseController@sort');
    Route::delete('{license}', 'LicenseController@delete');
});
