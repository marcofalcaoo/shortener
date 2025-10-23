<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUrlRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'original_url' => [
                'required',
                'url',
                'max:2048',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'original_url.required' => 'The URL is required.',
            'original_url.url' => 'The URL must be a valid URL.',
            'original_url.max' => 'The URL must not exceed 2048 characters.',
        ];
    }
}
