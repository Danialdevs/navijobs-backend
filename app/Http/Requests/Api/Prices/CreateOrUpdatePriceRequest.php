<?php

namespace App\Http\Requests\Api\Prices;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdatePriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'price' => 'required|numeric|min:0',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'application_id' => $this->route('application_id'),
        ]);
    }
}



