<?php

namespace App\Http\Controllers\Admin\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserAvatar;
use App\Http\Requests\UserCreate;
use App\Http\Requests\UserUpdate;
use Illuminate\Support\Facades\Hash;

trait UserController
{

    /**
     * Return all users in json
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $users = User::filter($request->all())->withNotActivated()->paginate($request->get('per_page', 20));
        foreach ($users as $user) {
            $user->plan = isset($user->subscription('main')->plan) ? $user->subscription('main')->plan : null;
        }
        return $users;
    }

    /**
     * Return user in request
     *
     * @param User
     *
     * @return User
     */
    public function get($user)
    {
        return $this->getUser($user);
    }

    /**
     * Create new user
     *
     * @param UserCreate $request
     *
     * @return User
     */
    public function create(UserCreate $request)
    {
        $data = $request->only(['email', 'firstname', 'lastname', 'company', 'gender',
            'role', 'country', 'city', 'state', 'address_1', 'address_2',
            'biography', 'facebook_link', 'youtube_link', 'twitter_link',
            'soundcloud_link']);
        $user = new User();
        $user->fill($data);
        $user->show_status = $request->has('show_status');
        $user->notification_comments = $request->has('notification_comments') ? $request->get('notification_comments') : false;
        $user->notification_inbox = $request->has('notification_inbox') ? $request->get('notification_inbox') : false;
        $user->notification_release = $request->has('notification_release') ? $request->get('notification_release') : false;
        $user->notification_reviews = $request->has('notification_reviews') ? $request->get('notification_reviews') : false;
        $user->notification_sale = $request->has('notification_sale') ? $request->get('notification_sale') : false;
        $user->show_country = $request->has('show_country') ? $request->get('show_country') : false;
        $user->show_skills = $request->has('show_skills') ? $request->get('show_skills') : false;
        $user->freelance = $request->has('freelance') ? $request->get('freelance') : false;
        $user->password = Hash::make($request->get('password'));
        $user->saveOrFail();
        return $user;
    }

    /**
     * Update the user
     *
     * @param UserUpdate $request
     *
     * @return User
     */
    public function update($user, UserUpdate $request)
    {
        $user = $this->getUser($user);
        $data = $request->only(['email', 'firstname', 'lastname', 'company', 'username',
            'gender', 'role', 'country', 'city', 'state', 'address_1', 'address_2',
            'show_status', 'notification_comments', 'notification_inbox',
            'notification_release', 'notification_reviews', 'notification_sale',
            'biography', 'freelance', 'facebook_link', 'youtube_link', 'twitter_link',
            'soundcloud_link', 'show_country', 'show_skills', 'activated']);
        $user->fill($data);
        $user->saveOrFail();
        $user->syncSkills($request->get('skillIds', []));
        $user->skillIds = $user->skills()->get();
        return $user;
    }

    /**
     * Update the user
     *
     * @param UserUpdate $request
     *
     * @return User
     */
    public function ban($user)
    {
        $user = $this->getUser($user);
        $user->banned_at = $user->banned_at ? null : Carbon::now();
        $user->saveOrFail();
        return $user;
    }


    /**
     * Update user avatar
     *
     * @param UserAvatar $request
     *
     * @return User
     */
    public function uploadAvatar($user, UserAvatar $request)
    {
        $user = $this->getUser($user);
        $user->setAvatar($request->file('avatar'));
        $user->saveOrFail();
        return $user;
    }

    /**
     * Delete user
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($user)
    {
        $user = $this->getUser($user);
        return [
            'status' => $user->delete()
        ];
    }

}
