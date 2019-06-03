<?php
Route::group(['middleware' => ['web', 'auth']], function() {
    Route::group(['prefix' => 'api/inbox', 'namespace' => 'Api\Inbox'], function() {
        Route::get('thread/deleted', 'InboxThreadController@deleted');
        Route::get('thread/sent', 'InboxThreadController@sent');
        Route::get('thread/counters', 'InboxThreadController@counters');
        Route::get('thread/archive', 'InboxThreadController@archive');
        Route::get('thread/starred', 'InboxThreadController@starred');
        Route::resource('thread', 'InboxThreadController');
        Route::resource('message', 'InboxMessageController');
        Route::get('thread/{id}/messages', 'InboxThreadController@messages');
        Route::post('thread/bulk-destroy', 'InboxThreadController@bulkDestroy');
        Route::post('thread/bulk-archive', 'InboxThreadController@bulkArchive');
        Route::post('thread/bulk-star', 'InboxThreadController@bulkStar');
        Route::post('thread/bulk-restore', 'InboxThreadController@bulkRestore');
        Route::post('thread/force-delete', 'InboxThreadController@forceDelete');
    });
});