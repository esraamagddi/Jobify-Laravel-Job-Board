<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'max:50|min:3',
            'salary_range' => 'regex:/^(?=.*[0-9])[\d-]+$/',
        ];
    }

    public function messages(): array
    {
        return [
            'title.max'=>'maximum length for title is 50 letters',
            'title.min' => 'minimum length for title is 3 letters',
            'salary_range.regex' => 'salary range should be numbers and - only',
        ];
    }
}
