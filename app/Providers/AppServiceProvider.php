<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Validation\UserValidation;
use App\Models\SupportTicket;
use App\Models\Item;
use App\Models\Story;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $this->configure();
        View::composer('*', function($view) {
            $user = Auth::user();
            $settings = \Illuminate\Support\Facades\App::make('Setting');
            $view->with('currentUser', $user);
            $view->with('settings', $settings);
            $view->with('categories', Category::orderBy('index')->where('enabled', true)->whereNull('procreator_id')->get());
        });
        View::composer('admin.*', function($view) {
            $view->with('openTickets', SupportTicket::where('is_solved', false)->count());
            $view->with('disapprovedStories', Story::where('approved', 0)->count());
            //awaiting review status
            $view->with('draftItems', Item::where('status', 1)->count());
        });
        
        //register new validation rule (user)
        Validator::resolver(function($translator, $data, $rules, $messages) {
            return new UserValidation($translator, $data, $rules, $messages);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    protected function configure() {
        // Notification SMTP settings
        try {
            config(['services.mailgun.domain' => \Setting::get('notification.mailgun.domain', config('services.mailgun.domain'))]);
            config(['services.mailgun.secret' => \Setting::get('notification.mailgun.secret', config('services.mailgun.secret'))]);
            config(['mail.from.address' => \Setting::get('notification.from.address', config('mail.from.address'))]);
            config(['mail.from.name' => \Setting::get('notification.from.name', config('mail.from.name'))]);
            config(['services.facebook.client_id' => \Setting::get('facebook.id', config('services.facebook.client_id'))]);
            config(['services.facebook.client_secret' => \Setting::get('facebook.secret', config('services.facebook.client_secret'))]);
            config(['services.facebook.redirect' => \Setting::get('facebook.redirect', config('services.facebook.redirect'))]);
            config(['services.facebook.redirect' => \Setting::get('facebook.redirect', config('services.facebook.redirect'))]);
            config(['services.stripe.key' => \Setting::get('stripe.key', config('services.stripe.key'))]);
            config(['services.stripe.secret' => \Setting::get('stripe.secret', config('services.stripe.secret'))]);
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            config(['services.stripe.client_id' => \Setting::get('stripe.id', config('services.stripe.client_id'))]);
            config(['services.stripe.client_secret' => \Setting::get('stripe.secret', config('services.stripe.client_secret'))]);
            config(['services.stripe.redirect' => \Setting::get('stripe.redirect', config('services.stripe.redirect'))]);
            config(['services.referral.percent.items' => \Setting::get('referral.percent.items')]);
            config(['services.referral.percent.subscriptions' => \Setting::get('referral.percent.subscriptions')]);
            config(['services.blog.price' => \Setting::get('blog.price')]);
            config(['services.paypal.sandbox' => \Setting::get('paypal.sandbox', config('services.paypal.sandbox'))]);
            config(['services.paypal.username' => \Setting::get('paypal.username', config('services.paypal.username'))]);
            config(['services.paypal.password' => \Setting::get('paypal.password', config('services.paypal.password'))]);
            config(['services.paypal.signature' => \Setting::get('paypal.signature', config('services.paypal.signature'))]);
            config(['services.paypal.app_id' => \Setting::get('paypal.appid', config('services.paypal.app_id'))]);
            config(['services.paypal.email' => \Setting::get('paypal.email', config('services.paypal.email'))]);

        } catch (\Exception $ex) {
            
        }
    }

}
