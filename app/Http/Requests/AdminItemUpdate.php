<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminItemUpdate extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:50',
            'slug' => 'required|string|min:3|max:50',
            'description' => 'nullable|max:5000',
            'categoriesIds' => 'required|array',
            'tagsIds' => 'nullable|array',
            'status' => 'required|numeric',
            'decline_reason' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:9999',
            'licensesIds' => 'required|array',
            'loopable' => 'boolean',
            'includes_stems' => 'boolean',
            'imageUrl' => 'nullable|string',
            'demoUrl' => 'nullable|string',
            'fileUrl' => 'nullable|string',
        ];
    }

}
