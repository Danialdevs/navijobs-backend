<?php

namespace App\Http\Requests\Api\Offices;

use Illuminate\Foundation\Http\FormRequest;

class CreateOfficeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'company_id' => $this->user()->company_id, // Add company_id to the request data
        ]);
    }
}
