<?php

Route::get('countries', 'CountryController@index')->name('admin.country.list');

Route::group(['prefix' => 'api/country'], function () {
    Route::get('list', 'CountryController@all');
    Route::post('store', 'CountryController@store');
    Route::delete('{country}', 'CountryController@delete');
});

?>
