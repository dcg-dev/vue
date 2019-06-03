<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SettingsUpdate extends FormRequest {

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
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:male,female',
            'country' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'address_1' => 'nullable|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'current_password' => 'nullable|old_password|min:6',
            'new_password' => 'nullable|required_with:new_password_confirmation|min:6|confirmed',
            'new_password_confirmation' => 'nullable|required_with:new_password|min:6',
            'accepted' => 'required_if:tab,general',
            'show_status' => 'required|boolean',
            'notification_comments' => 'required|boolean',
            'notification_inbox' => 'required|boolean',
            'notification_release' => 'required|boolean',
            'notification_reviews' => 'required|boolean',
            'notification_sale' => 'required|boolean',
            'stripe_account_id' => 'nullable|string'
        ];
    }
}