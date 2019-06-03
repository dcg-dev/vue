<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqTopicCreate extends FormRequest {

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
            'question' => 'required|string',
            'answer' => 'required',
            'faq_category_id' => 'required|integer|exists:faq_categories,id',
            'types' => 'nullable|array'
        ];
    }

}
