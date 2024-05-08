<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title' => 'required|max:50|min:3',
            'description' => 'required',
            'responsibilities' => 'required',
            'skills' => 'required',
            'qualifications' => 'required',
            'salary_range' => 'required',
            'work_type' => 'required',
            'location' => 'required',
            'deadline' => 'required',
            'employer_id' => 'required',
            'category_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'title is required',
            'title.max'=>'maximum length for title is 50 letters',
            'title.min' => 'minimum length for title is 3 letters',
            'description.required' => 'description is required',
            'responsibilities.required' => 'responsibilities are required',
            'skills.required' => 'skills are required',
            'qualifications.required' => 'qualifications are required',
            'salary_range.required' => 'salary range is required',
            'work_type.required' => 'work type is required',
            'location.required' => 'location is required',
            'deadline.required' => 'deadline is required',
            'employer_id.required' => 'employer is required',
            'category_id.required' => 'category is required',
        ];
    }
}
