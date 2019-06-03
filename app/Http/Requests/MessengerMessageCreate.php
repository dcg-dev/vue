<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class MessengerMessageCreate
 * @package App\Http\Requests
 */
class MessengerMessageCreate extends FormRequest {

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
            'thread' => 'required|integer|exists:messenger_threads,id',
            'message' => 'required|string|max:500',
        ];
    }

}
