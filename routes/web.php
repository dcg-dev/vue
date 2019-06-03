<?php

Auth::routes();
Route::get('activation/{token}', 'UserController@activation')->name('user.activation');
Route::get('redirect', 'UserController@redirect')->name('redirect');
Route::group(['prefix' => 'control', 'middleware' => ['web', 'auth', 'admin'], 'namespace' => 'Admin'], function () {
    include 'admin/setting.php';
    include 'admin/category.php';
    include 'admin/blog.php';
    include 'admin/item.php';
    include 'admin/user.php';
    include 'admin/billing.php';
    include 'admin/affiliate.php';
    include 'admin/support.php';
    include 'admin/dashboard.php';
    include 'admin/order.php';
    include 'admin/tag.php';
    include 'admin/license.php';
    include 'admin/format.php';
    include 'admin/subscription.php';
    include 'admin/promotional.php';
    include 'admin/country.php';
    Route::get('/', function () {
        return view('admin.dashboard.index');
    })->name('admin.dashboard');
});
include 'web/tag.php';
include 'web/skill.php';
include 'web/category.php';
include 'web/profile.php';
include 'web/item.php';
include 'web/comment.php';
include 'web/format.php';
include 'web/license.php';
include 'web/oauth.php';
include 'web/user.php';
include 'web/blog.php';
include 'web/page.php';
include 'web/collection.php';
include 'web/billing.php';
include 'web/affiliate.php';
include 'web/checkout.php';
include 'web/messenger.php';
include 'web/order.php';
include 'web/support.php';
include 'web/paypal.php';
Route::post(
    'stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
);

Route::get('/', 'PageController@dashboard')->name('dashboard');

