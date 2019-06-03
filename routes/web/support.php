<?php

Route::group(['middleware' => ['web']], function() {

    Route::group(['prefix' => 'support'], function() {
        Route::get('faq', 'SupportController@faqView')->name('support.faq.view'); 
        
        Route::group(['prefix' => 'ticket', 'middleware' => ['auth']], function() {
            Route::get('list', 'SupportController@ticketListView')->name('support.ticket.list'); 
            Route::get('{ticket}', 'SupportController@ticketView')->name('support.ticket.view');
        });
    });
    
    Route::group(['prefix' => 'api/support'], function() {
        Route::group(['prefix' => 'faq'], function() {
            Route::group(['prefix' => 'topic'], function() {
                Route::get('all', 'SupportController@allFaqTopics');
            });
        });
        
        Route::group(['prefix' => 'ticket', 'middleware' => ['auth']], function() {
            Route::get('my', 'SupportController@mySupportTickets');
            Route::post('create', 'SupportController@createTicket');
            Route::get('{ticket}', 'SupportController@getTicket');
            Route::post('{ticket}/reply', 'SupportController@replyOnTicket');
        });
    });
    
});
