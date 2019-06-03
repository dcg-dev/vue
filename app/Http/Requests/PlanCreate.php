<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanCreate extends FormRequest {

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
            'name' => 'required|string|min:3|max:50',
            'stripe_id' => 'required|unique:plans,stripe_id|min:3|max:50|regex:/^[a-z0-9](-?[a-z0-9]+)$/i',
            'products'=> 'required|numeric|min:0',
            'commission'=> 'required|numeric',
            'price'=> 'required|numeric',
            'paypal'=> 'nullable|boolean',
            'card'=> 'nullable|boolean',
            'social_accounts'=> 'nullable|boolean',
            'builder'=> 'nullable|boolean',
            'notifications'=> 'nullable|boolean',
            'support'=> 'nullable|boolean',
            'enabled'=> 'nullable|boolean',
            'badge'=> 'nullable|string',
        ];
    }

}
