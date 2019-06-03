<?php
Route::group(['prefix' => 'api/dashboard'], function() {
    Route::get('/info', 'DashboardController@getDashboard');
    Route::get('/statistics/{type}', 'DashboardController@getStatistics');
    Route::get('/current/{group}/{type}', 'DashboardController@getCurrent');
});
