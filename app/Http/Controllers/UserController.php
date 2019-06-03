<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use Kryptonit3\Counter\Facades\CounterFacade as Counter;

class UserController extends Controller
{

    use Api\UserController;

    public function view(User $user)
    {
        Counter::count('user.view', $user->username);
        return view('user.view', ['user' => $user]);
    }

    public function followers(User $user)
    {
        Counter::count('user.view', $user->username);
        return view('user.followers', ['user' => $user]);
    }

    public function following(User $user)
    {
        Counter::count('user.view', $user->username);
        return view('user.following', ['user' => $user]);
    }

    public function items(User $user)
    {
        Counter::count('user.view', $user->username);
        return view('user.items', ['user' => $user]);
    }

    public function collections(User $user)
    {
        Counter::count('user.view', $user->username);
        return view('user.collections', ['user' => $user]);
    }

    public function ratings(User $user)
    {
        Counter::count('user.view', $user->username);
        return view('user.ratings', ['user' => $user]);
    }

    public function feed()
    {
        return view('user.feed');
    }

    public function topSellers()
    {
        return view('user.top-sellers');
    }


    public function activation($token)
    {
        $user = User::withNotActivated()->where('activation_token', $token)->first();
        if ($user) {
            $user->activated = 1;
            $user->activation_token = null;
            $user->saveOrFail();
            \Illuminate\Support\Facades\Auth::guard()->login($user);
            return redirect()->route('redirect', [
                'url' => route('profile.settings')
            ]);
        } else {
            abort(403);
        }
    }

    public function redirect()
    {
        return redirect(Request::get('url'));
    }

}
