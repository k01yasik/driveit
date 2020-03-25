<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DraftRequest extends FormRequest
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
            'slug' => 'required|unique:posts|unique:drafts|max:191',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'name' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'body' => 'nullable|string',
            'image' => 'nullable|string'
        ];
    }
}
