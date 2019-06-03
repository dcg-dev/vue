<?php
Route::group(['prefix' => 'api/tag'], function() {
    Route::get('list', 'TagController@all');
});