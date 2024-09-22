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
            'name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->route('id'),
            'password' => 'nullable|string|min:8', // Make password nullable for updates
            'role' => 'required|string|in:worker,company_admin,office_admin,office_manager',
            'company_office_id' => 'nullable|exists:company_offices,id',
            'sex' => 'nullable|in:male,female',
            'data_birthday' => 'nullable|date',
        ];
    }
}
