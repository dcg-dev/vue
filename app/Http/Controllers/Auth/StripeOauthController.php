<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class StripeOauthController extends Controller {

    protected $providerName = 'stripe';
    
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Redirect the user to the Provider authentication page.
     * 
     * @return Response
     */
    public function redirectToProvider() {
        return Socialite::driver($this->providerName)->stateless()->redirect();
    }

    /**
     * Obtain the user information from Stripe provider.
     * 
     * @return Response
     */
    public function handleProviderCallback() {
        $data = Socialite::driver($this->providerName)->stateless()->user();
        $user = $this->user();
        $user->stripe_account_id = $data->id;
        $user->save();
        return redirect('/profile/settings');
    }

}
