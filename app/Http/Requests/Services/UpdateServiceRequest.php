<?php

namespace App\Http\Requests\Services;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    /**

     *Get the validation rules that apply to the request.
     * @return bool
     */
    public function authorize(): bool
    {

        return true;
    }

    /**
     * Prepare the data for validation.
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
        ];
    }


    protected function prepareForValidation()
    {
        $this->merge([
            'name' => trim($this->input('name')),
            'address' => trim($this->input('address')),
        ]);
    }
}
