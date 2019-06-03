<?php

Route::group(['middleware' => ['web']], function() {
    Route::get('sellers/top', 'UserController@topSellers')->name('sellers.top');
    Route::group(['prefix' => 'user'], function() {
        Route::get('/{user}', 'UserController@view')->name('user.view');
        Route::get('/{user}/followers', 'UserController@followers')->name('user.followers');
        Route::get('/{user}/following', 'UserController@following')->name('user.following');
        Route::get('/{user}/items', 'UserController@items')->name('user.items');
        Route::get('/{user}/collections', 'UserController@collections')->name('user.collections');
        Route::get('/{user}/ratings', 'UserController@ratings')->name('user.ratings');
    });

    Route::group(['prefix' => 'api/user'], function() {
        Route::get('list', 'UserController@all');
        Route::get('current', 'UserController@current');
        Route::get('feed', 'UserController@getFeed');
        Route::get('feed/count', 'UserController@getFeedCount');
        Route::group(['middleware' => ['auth']], function() {
            Route::get('favourites', 'UserController@favourites');
            Route::post('{user}/follow', 'UserController@follow');
            Route::post('{user}/unfollow', 'UserController@unfollow');
            Route::post('{user}/unfollow/email', 'UserController@unfollowEmail');
            Route::post('{user}/follow/email', 'UserController@followEmail');
            Route::post('{user}/follow/toggle', 'UserController@followToggle');
        });
        Route::get('{user}/collections', 'UserController@getCollections');
        Route::get('{user}', 'UserController@overview');
        Route::get('{user}/refresh', 'UserController@overview');
        Route::get('{user}/followers', 'UserController@getFollowers');
        Route::get('{user}/following', 'UserController@getFollowing');
        Route::get('{user}/items', 'ItemController@userItems');
        Route::get('{user}/friends', 'UserController@friends');
        Route::get('{user}/ratings', 'UserController@userRatings');
    });
});
