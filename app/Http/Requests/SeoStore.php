<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeoStore extends FormRequest
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
            'route' => 'required|string|unique:seo,route_name',
            'title' => 'required|string',
            'description' => 'required|string'
        ];
    }
}
