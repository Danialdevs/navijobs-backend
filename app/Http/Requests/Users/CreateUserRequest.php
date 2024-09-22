<?php

namespace App\Http\Requests\Users;

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
            'name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:worker,company_admin,office_manager',
            'office_id' => 'nullable|exists:offices,id',
            'company_id' => 'nullable|exists:companies,id',
        ];

    }

    protected function prepareForValidation()
    {
        $this->merge([
            'office_id' => $this->user()->office_id, // Add company_id to the request data
            'role' => $this->user()->role,
        ]);
    }
}
