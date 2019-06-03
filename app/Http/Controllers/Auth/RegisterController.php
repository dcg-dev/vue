<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class RegisterController extends Controller {

    use RegistersUsers;

    protected $redirectTo = '/login';

    public function __construct() {
        $this->middleware('guest');
    }

    protected function validator(array $data) {
        return Validator::make($data, [
                    'username' => 'required|max:255|unique:users|alpha_dash',
                    'email' => 'required|email|max:255|cewl|unique:users',
                    'password' => 'required|min:6|confirmed',
                    'password_confirmation' => 'required|min:6',
                    'accepted' => 'required|accepted',
        ]);
    }

    protected function create(array $data) {
        return User::create([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {
        $user = User::where('email', $request->get('email'))->onlyTrashed()->first();
        if($user) {
            $user->restore();
            $user->username = $request->get('username');
            $user->password = bcrypt($request->get('username'));
            $user->save();
        } else {
            $this->validator($request->all())->validate();
            $user = $this->create($request->all());
        }
        event(new Registered($user));
//        $this->guard()->login($user);
        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

}