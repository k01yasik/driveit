<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvatarImage extends FormRequest
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
            'avatar_upload' => 'required|image',
            'x' => 'required|integer',
            'y' => 'required|integer',
            'height' => 'required|integer',
            'width' => 'required|integer'
        ];
    }
}
