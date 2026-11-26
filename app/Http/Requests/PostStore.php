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
            'slug' => [$this->routeIs('admin.posts.store') ? 'required' : 'sometimes', 'string', 'max:191'],
            'image' => 'required|url',
            'title' => 'required',
            'description' => 'required',
            'name' => 'required',
            'category' => 'required|integer|exists:categories,id',
            'caption' => 'required',
            'body' => 'required',
        ];
    }
}
