<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BodyImageUpload extends FormRequest
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
            'upload_image_form_input' => 'required|image',
            'type' => 'required'
        ];
    }
}
