<?php

Route::group(['prefix' => 'affiliate'], function() {
    Route::get('requests', 'AffiliateController@requestList')->name('admin.affiliate.request.list');
    Route::get('sales', 'AffiliateController@saleList')->name('admin.affiliate.sale.list');
    Route::get('configuration', 'AffiliateController@configuration')->name('admin.affiliate.configuration');
    
    Route::group(['prefix' => 'request'], function() {
        Route::get('{request}/edit', 'AffiliateController@viewRequestEdit')->name('admin.affiliate.request.edit');
    });
    
    Route::group(['prefix' => 'sale'], function() {
        Route::get('{sale}/edit', 'AffiliateController@viewSaleEdit')->name('admin.affiliate.sale.edit');
    });
});

Route::group(['prefix' => 'api/affiliate'], function() {
    Route::group(['prefix' => 'request'], function() {
        Route::get('list', 'AffiliateController@getRequests');
        Route::get('{affiliateRequest}', 'AffiliateController@getRequest');
        Route::post('{affiliateRequest}/close', 'AffiliateController@closeRequest');
        Route::post('{affiliateRequest}/update', 'AffiliateController@updateRequest');
    });
    
    Route::group(['prefix' => 'sale'], function() {
        Route::get('list', 'AffiliateController@getSales');
        Route::get('{sale}', 'AffiliateController@getSale');
        Route::post('{sale}/update', 'AffiliateController@updateSale');
    });
});
