<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
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
            'name' => [ 'required', 'string', 'min:3', 'max:255' ],
            'email' => [ 'required', 'unique:App\Models\User,email', 'email', 'string' ],
            'password' => [ 'required', 'string', 'min:8' ],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => "The user's name",
                'example' => 'John Doe',
            ],
            'email' => [
                'description' => "The user's email",
                'example' => 'john@example.com',
            ],
            'password' => [
                'description' => "The user's password",
                'example' => 'no-example',
            ],
        ];
    }
}
