<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

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

    public function after(): array
    {
        return [function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            [$width, $height] = $this->file('avatar_upload')->dimensions() ?: [0, 0];
            if ($this->integer('width') > $width - $this->integer('x')
                || $this->integer('height') > $height - $this->integer('y')) {
                $validator->errors()->add('avatar_upload', __('The crop area must fit inside the avatar image.'));
            }
        }];
    }
}
