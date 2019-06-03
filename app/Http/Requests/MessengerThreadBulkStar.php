<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class MessengerThreadBulkStar
 * @package App\Http\Requests
 */
class MessengerThreadBulkStar extends FormRequest {

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
            'ids' => 'required|array',
            'value' => 'required|boolean'
        ];
    }

}
