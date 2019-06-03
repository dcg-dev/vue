<?php

Route::group(['middleware' => ['web', 'auth']], function() {
    Route::group(['prefix' => 'api/comment'], function() {
        Route::post('{comment}/replied', 'CommentController@replied')->middleware('can:replied,comment');
        Route::post('{comment}/like', 'CommentController@like')->middleware('can:liked,comment');
    });
});



