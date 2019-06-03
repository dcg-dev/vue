<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CompleteOrder extends FormRequest {

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
        $accountRules = [
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'password' => 'required||min:6|confirmed',
            'password_confirmation' => 'required||min:6'
        ];

        $cardRules = [
            'card_name' => 'nullable|required_if:payment_type,stripe|string|max:255',
            'token' => 'nullable|required_if:edit_mode,true|string'
        ];

        return Auth::user() ? $cardRules : array_merge($accountRules, $cardRules);
    }
}