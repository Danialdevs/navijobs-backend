<?php

namespace App\Http\Requests\Services;

use Illuminate\Foundation\Http\FormRequest;

class CreateServiceRequest extends FormRequest
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
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'company_id' => 'required|exists:companies,id',
        ];
    }

    /**
     * Prepare the data for validation.
     */
//    protected function prepareForValidation()
//    {
//        $this->merge([
//            'company_id' => $this->user()->company_id, // Add company_id to the request data
//        ]);
//    }
}
