<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEmployerRequest extends FormRequest
{
    /**
     * DeterSymfony\\Component\\HttpKernel\\Exception\\NotFoundHttpExceptionmine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */ 
    public function rules(): array
    {
        return [
            'name' => 'required|max:50|min:3',
            'email' => 'required|unique:employers|email|max:50',
            'logo' => 'nullable',
            'industry' => 'required|max:50',
            'password' => 'required|max:16|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+\-={}[\]:;"\'<>,.?\/]).{8,}$/',
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'name is required',
            'name.max'=>'maximum length for name is 50 letters',
            'name.min' => 'name must be at least 3 characters long',
            'email.required' => 'emaik is required',
            'email.unique' => 'this email is already exists',
            'email.regex' => 'invalid email',
            'password.required' => 'Password is required',
            'password.max' => 'Password cannot be longer than 16 characters',
            'password.min' => 'Password must be at least 8 characters',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character',
            'industry.required' => 'industry is required',
            'industry.max'=>'maximum length for industry is 50 letters',
            'logo.max'=> 'maximum length for logo name is 50 letters',
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
