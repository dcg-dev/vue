<?php
Route::group(['prefix' => 'api/skill'], function() {
    Route::get('list', 'SkillController@all');
});