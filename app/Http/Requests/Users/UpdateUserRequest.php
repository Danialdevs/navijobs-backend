<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'string',
            'middle_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'sex' => 'string',
            'data_birthday' => 'nullable|date',
            'avatar' => 'nullable|string',
            'email' => 'email|unique:users,email',
            'role' => 'string',
        ];
    }
}
