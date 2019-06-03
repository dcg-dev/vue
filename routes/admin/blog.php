<?php

Route::group(['prefix' => 'blog'], function() {
    
    Route::group(['prefix' => 'story'], function() {
        Route::get('create', 'StoryController@viewCreate')->name('admin.blog.story.create');
        Route::get('{story}/edit', 'StoryController@viewEdit')->name('admin.blog.story.edit');
    });
    Route::get('stories', 'BlogController@stories')->name('admin.blog.story.list');
});

Route::group(['prefix' => 'api/story'], function() {
    Route::get('list', 'StoryController@all');
    Route::get('{story}', 'StoryController@get');
    Route::post('{story}/approving', 'StoryController@approving');
    Route::post('create', 'StoryController@create');
    Route::post('{story}/update', 'StoryController@update');
    Route::post('{story}/image', 'StoryController@uploadImage')->name('admin.blog.story.image');
    Route::delete('{story}', 'StoryController@delete');
});