<?php
Route::get('start-selling', 'PageController@startSelling')->name('start_selling');
Route::get('community', 'PageController@community')->name('community');
Route::get('pricing', 'PageController@pricing')->name('pricing');

Route::get('affiliates', function () {
    return view('page.affiliates');
});
Route::get('our-company', function () {
    return view('page.our-company');
});
Route::get('privacy-policy', function () {
    return view('page.privacy-policy');
});
Route::get('terms-of-service', function () {
    return view('page.terms-of-service');
});
