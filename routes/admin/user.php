<?php

Route::group(['prefix' => 'user'], function() {
    
    Route::get('create', 'UserController@viewCreate')->name('admin.user.create');
    Route::get('{user}/edit', 'UserController@viewEdit')->name('admin.user.edit');
        
    Route::get('skills', 'UserController@skills')->name('admin.user.skill.list');
    Route::get('list', 'UserController@users')->name('admin.user.list');
});

Route::group(['prefix' => 'api/skill'], function() {
    Route::get('list', 'UserSkillController@all');
    Route::get('{skill}', 'UserSkillController@get');
    Route::post('{skill}/approving', 'UserSkillController@approving');
    Route::post('create', 'UserSkillController@create');
    Route::post('{skill}/update', 'UserSkillController@update');
    Route::delete('{skill}', 'UserSkillController@delete');
});

Route::group(['prefix' => 'api/user'], function() {
    Route::get('list', 'UserController@all');
    Route::get('{user}', 'UserController@get');
    Route::post('create', 'UserController@create');
    Route::post('{user}/update', 'UserController@update');
    Route::post('{user}/ban', 'UserController@ban');
    Route::delete('{user}', 'UserController@delete');
    Route::post('{user}/avatar', 'UserController@uploadAvatar')->name('admin.user.avatar');
});