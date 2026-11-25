<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvatarImageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'avatar_upload' => 'required|image|max:5000',
            'x' => 'required|integer|min:0',
            'y' => 'required|integer|min:0',
            'width' => 'required|integer|min:1',
            'height' => 'required|integer|min:1',
        ];
    }
}
