<?php

Route::group(['middleware' => ['web']], function() {

    Route::group(['prefix' => 'blog'], function() {
        Route::get('/stories', 'BlogController@stories')->name('blog.story.list');
        
        Route::group(['prefix' => 'story'], function() {
            Route::get('publisher', 'StoryController@publisher'); //return random publisher
            Route::get('{story}', 'StoryController@view')->name('blog.story.view');
            
            Route::group(['middleware' => ['auth']], function() {
                Route::get('{story}/publish', 'StoryController@publishView')->name('blog.story.publish');
            });
        });
    });
    
    Route::group(['prefix' => 'api/blog'], function() {
        Route::group(['prefix' => 'story'], function() {
            Route::get('list', 'StoryController@all');
            Route::get('{story}', 'StoryController@get');
            Route::get('{story}/creator', 'StoryController@creator');
            Route::get('{story}/comments', 'StoryController@comments');
            Route::group(['middleware' => ['auth']], function() {
                Route::post('create', 'StoryController@create');
                Route::post('book', 'StoryController@book');
                Route::post('{story}/like', 'StoryController@like');
                Route::post('{story}/commented', 'StoryController@commented');
                Route::post('{story}/image', 'StoryController@uploadImage');
                Route::post('{story}/publish', 'StoryController@publish');
            });
        });
        
        Route::group(['prefix' => 'comment'], function() {
            Route::group(['middleware' => ['auth']], function() {
                Route::post('{comment}/replied', 'StoryCommentController@replied');
                Route::post('{comment}/like', 'StoryCommentController@like');
            });
        });
    });

});
