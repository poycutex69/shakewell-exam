<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'username' => 'required|unique|max:255',
            'email' => 'required|email|max:255',
            'first_name' => 'required|max:255',

        ];
    }

    /**
     * Get the validation messages
     *
     * @return  array
     */
    public function messages(): array
    {
        return [
            'username.required' => 'User name is required.',
            'username.unique' => 'User name is already taken.',
            'username.max' => 'User name must not exceed 255 characters.',
            'email.required' => 'Email is required.',
            'email.unique' => 'Email is already taken.',
            'email.max' => 'Email must not exceed 255 characters.',
            'first_name.required' => 'First name is required.',
            'first_name.max' => 'First name must not exceed 255 characters.',
        ];
    }
}
