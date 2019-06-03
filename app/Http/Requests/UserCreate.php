<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreate extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

     /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'email' => 'required|email|cewl|unique:users,email',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:male,female',
            'role' => 'required|string|in:admin,user',
            'password' => 'required|string|min:6|max:255',
            'country' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'address_1' => 'nullable|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'show_status' => 'boolean',
            'notification_comments' => 'boolean',
            'notification_inbox' => 'boolean',
            'notification_release' => 'boolean',
            'notification_reviews' => 'boolean',
            'notification_sale' => 'boolean',
            'biography' => 'nullable|max:5000',
            'freelance' => 'boolean',
            'facebook_link' => 'nullable|url|regex:/http(?:s):\/\/(?:www\.)facebook\.com\/.+/i',
            'youtube_link' => 'nullable|url|regex:/http(?:s):\/\/(?:www\.)youtube\.com\/.+/i',
            'twitter_link' => 'nullable|url|regex:/http(?:s):\/\/(?:www\.)twitter\.com\/.+/i',
            'soundcloud_link' => 'nullable|url|regex:/http(?:s):\/\/(?:www\.)soundcloud\.com\/.+/i',
            'show_country' => 'boolean',
            'show_skills' => 'boolean',
        ];
    }

}
