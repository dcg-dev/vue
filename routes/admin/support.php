<?php

Route::group(['prefix' => 'support'], function() {
    Route::group(['prefix' => 'faq'], function() {
        Route::group(['prefix' => 'category'], function() {
            Route::get('list', 'FaqController@categories')->name('admin.support.faq.category.list');
        });

        Route::group(['prefix' => 'topic'], function() {
            Route::get('list', 'FaqController@topics')->name('admin.support.faq.topic.list');
        });
    });
    
    Route::group(['prefix' => 'ticket'], function() {
        Route::get('list', 'TicketController@viewList')->name('admin.support.ticket.list');
        Route::get('{ticket}/edit', 'TicketController@viewEdit')->name('admin.support.ticket.edit');
    });
});

Route::group(['prefix' => 'api/support'], function() {
    Route::group(['prefix' => 'faq'], function() {
        Route::group(['prefix' => 'category'], function() {
            Route::get('list', 'FaqController@getCategories');
            Route::get('all', 'FaqController@allCategories');
            Route::post('create', 'FaqController@createCategory');
            Route::get('{category}', 'FaqController@getCategory');
            Route::delete('{category}', 'FaqController@deleteCategory');
            Route::post('{category}/update', 'FaqController@updateCategory');
        });

        Route::group(['prefix' => 'topic'], function() {
            Route::get('list', 'FaqController@getTopics');
            Route::post('create', 'FaqController@createTopic');
            Route::get('{topic}', 'FaqController@getTopic');
            Route::delete('{topic}', 'FaqController@deleteTopic');
            Route::post('{topic}/update', 'FaqController@updateTopic');
        });
    });
    
    Route::group(['prefix' => 'ticket'], function() {
        Route::get('list', 'TicketController@getTickets');
        Route::get('{ticket}', 'TicketController@getTicket');
        Route::delete('{ticket}', 'TicketController@deleteTicket');
        Route::post('{ticket}/update', 'TicketController@updateTicket');
    });
});
