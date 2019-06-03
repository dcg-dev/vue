<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdate extends FormRequest {

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
            'biography' => 'nullable|max:5000',
            'freelance' => 'boolean',
            'facebook_link' => 'nullable|url|regex:/http(?:s):\/\/(?:www\.)facebook\.com\/.+/i',
            'youtube_link' => 'nullable|url|regex:/http(?:s):\/\/(?:www\.)youtube\.com\/.+/i',
            'twitter_link' => 'nullable|url|regex:/http(?:s):\/\/(?:www\.)twitter\.com\/.+/i',
            'soundcloud_link' => 'nullable|url|regex:/http(?:s):\/\/(?:www\.)soundcloud\.com\/.+/i',
            'show_country' => 'boolean',
            'show_skills' => 'boolean',
            'skills' => 'array',
            'firstname' => 'string|max:255',
            'lastname' => 'string|max:255',
            'country' => 'string|max:255',
           // 'paypal_email' => 'string|max:255',
        ];
    }

}