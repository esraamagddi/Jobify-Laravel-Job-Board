<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       // if (auth()->check()) {
        //     $user = auth()->user();
    
        //     if ($user->role === 'admin') {
        //         return true;
        //     }
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
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:admins,email,' . auth()->user()->id,
            'password' => 'sometimes|string|max:16|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+\-={}[\]:;"\'<>,.?\/]).{8,}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'name.max'=>'maximum length for name is 255 letters',
            'name.min' => 'name must be at least 3 characters long',
            'email.unique' => 'this email is already exists',
            'email.regex' => 'invalid email',
            'password.max' => 'Password cannot be longer than 16 characters',
            'password.min' => 'Password must be at least 8 characters',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character',

        ];
    }
    protected function failedValidation(Validator $validator)
    {
            $errors = (new ValidationException($validator))->errors();
            throw new HttpResponseException(
                response()->json(['data' => $errors], 422)
            );
    }
}

