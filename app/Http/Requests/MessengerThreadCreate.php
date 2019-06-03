<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class MessengerThreadCreate
 * @package App\Http\Requests
 */
class MessengerThreadCreate extends FormRequest {

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
            'subject' => 'required|string|min:3|max:100',
            'message'=> 'required|string|min:1|max:5000',
            'recipients' => 'required|integer|exists:users,id'
        ];
    }

}
