<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'body' => 'required|string',
            'image_path' => 'nullable|string',
            'is_published' => 'boolean',
            'date_published' => 'nullable|date',
        ];
    }
}
