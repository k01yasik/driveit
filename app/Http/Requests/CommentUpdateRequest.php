<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $ability = $this->routeIs('admin.comment.update') ? 'moderate' : 'update';

        return $this->user()->can($ability, $this->route('comment'));
    }

    public function rules(): array
    {
        return ['message' => ['required', 'string', 'max:5000']];
    }
}
