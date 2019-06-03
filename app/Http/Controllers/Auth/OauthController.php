<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OauthController extends Controller {

    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Redirect the user to the Provider authentication page.
     * 
     * @param string $provider Name of provider
     * @return Response
     */
    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.
     * 
     * @param string $provider Name of provider
     * @return Response
     */
    public function handleProviderCallback($provider) {
        $data = Socialite::driver($provider)->user();
        $name = explode(" ", $data->getName());
        $attributes = [
            'email' => $data->getEmail(),
            'facebook_id' => $data->getId(),
            'gender' => strtolower(array_get($data->getRaw(), 'gender')),
            'firstname' => trim(array_get($name, 0)),
            'lastname' => trim(array_get($name, 1)),
            'password' => bcrypt(str_random(20)),
            'is_empty_password' => true
        ];
        $user = User::where('email', $data->getEmail())->onlyTrashed()->first();
        if($user) {
            $user->restore();
            $user->fill($attributes);
            $user->save();
        } else {
            $user = User::where('email', $data->getEmail())->orWhere('facebook_id', $data->getId())->firstOrCreate($attributes);
        }
        if ($user) {
            Auth::guard()->login($user, true);
            if (Auth::guard()->check()) {
                try {
                    if (!$user->hasAvatar() && $user->setAvatarByUrl($data->avatar_original)) {
                        $user->saveOrFail();
                    }
                } catch (\Exception $ex) {
                    
                }
            }
            return redirect()->back();
        }
    }

}
