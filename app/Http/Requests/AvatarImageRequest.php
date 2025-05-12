<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvatarImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'avatar_upload' => 'required|image|max:5000',
            'x' => 'required|numeric',
            'y' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
        ];
    }
}
