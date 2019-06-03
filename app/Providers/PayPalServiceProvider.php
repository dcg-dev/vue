<?php

namespace App\Providers;

use App\Services\PayPalPayment;
use Illuminate\Support\ServiceProvider;

class PayPalServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->registerPayPal();
    }

    /**
     * Register Expedia api.
     *
     * @return void
     */
    public function registerPayPal() {
        $this->app->singleton('PayPalPayment', function ($app) {
            $sandbox   = config('services.paypal.sandbox');
            $username  = config('services.paypal.username');
            $password  = config('services.paypal.password');
            $signature = config('services.paypal.signature');
            $appId     = config('services.paypal.app_id');

            $instance = new PayPalPayment($username, $password, $signature, $appId, $sandbox);

            $instance->setCancelUrl(route('paypal.cancel'));
            $instance->setSuccessUrl(route('paypal.success'));
            $instance->setIpnNotificationUrl(route('paypal.ipn'));

            return $instance;
        });
    }
}
