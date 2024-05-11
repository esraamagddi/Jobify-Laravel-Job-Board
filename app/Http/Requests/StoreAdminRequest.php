<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAdminRequest extends FormRequest
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
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|max:16|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+\-={}[\]:;"\'<>,.?\/]).{8,}$/',
            'role'=>'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'name is required',
            'name.max'=>'maximum length for name is 255 letters',
            'name.min' => 'name must be at least 3 characters long',
            'email.required' => 'email is required',
            'email.unique' => 'this email is already exists',
            'email.regex' => 'invalid email',
            'password.required' => 'Password is required',
            'password.max' => 'Password cannot be longer than 16 characters',
            'password.min' => 'Password must be at least 8 characters',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character',
            'role.required' => 'role is required',

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

