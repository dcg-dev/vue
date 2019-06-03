<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStore extends FormRequest {

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
            'id' => 'nullable|exists:categories,id',
            'name' => 'required_if:id,null|string|min:3|max:122',
            'procreator_id'=> 'nullable|exists:categories,id',
            'enabled'=> 'nullable|boolean',
        ];
    }

}
