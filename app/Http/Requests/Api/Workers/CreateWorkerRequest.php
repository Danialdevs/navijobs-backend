<?php
namespace App\Http\Requests\Api\Workers;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'application_id' => 'required|exists:applications,id',
        ];
    }
}



