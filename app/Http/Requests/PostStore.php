<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStore extends FormRequest
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
            'image' => 'required|url',
            'slug' => 'required|alpha_dash|unique:posts',
            'title' => 'required',
            'description' => 'required',
            'name' => 'required',
            'category' => 'required|integer',
            'caption' => 'required',
            'body' => 'required',
        ];
    }
}
