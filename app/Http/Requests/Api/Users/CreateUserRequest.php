<?php

namespace App\Http\Requests\Api\Users;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'sex'=> 'required|enum',
            'data_birthday' => 'nullable|date',
            'avatar' => 'nullable|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'office_id' => $this->user()->office_id, // Add company_id to the request data
            'role' => $this->user()->role
        ]);
    }
}
