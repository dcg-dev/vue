<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemAudio extends FormRequest
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
            'demo' => 'required|file|mimetypes:application/octet-stream,audio/mp3,audio/mpeg3,audio/x-mpeg-3,video/mpeg,video/x-mpeg,audio/mpeg,application/zip|max:24000',
        ];
    }

}
