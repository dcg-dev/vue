<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{

    use Api\UserController;

    /**
     * Show the skills list
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        return view('admin.user.list');
    }

    /**
     * Show the skills list
     *
     * @return \Illuminate\Http\Response
     */
    public function skills()
    {
        return view('admin.user.skill.list');
    }

    /**
     * Show the form to create new user
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCreate()
    {
        return view('admin.user.create');
    }

    /**
     * Show the form to edit user
     *
     * @param User
     *
     * @return \Illuminate\Http\Response
     */
    public function viewEdit($user)
    {
        $user = $this->getUser($user);
        return view('admin.user.edit', ['user' => $user]);
    }

    public function getUser($slug)
    {
        $user = User::withNotActivated()->where('username', $slug)->first();
        if ($user) {
            return $user;
        }
        abort(404, 'User not found');
    }

}
