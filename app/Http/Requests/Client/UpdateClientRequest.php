<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('client')->id;

        return [
            'email'    => 'sometimes|email|unique:clients,email,' . $id,
            'adresse'    => 'sometimes|string',
            'last_name'    => 'sometimes|string',
            'first_name'    => 'sometimes|string',
            'phone_number'    => 'sometimes|string|unique:clients,phone_number,' . $id,
        ];
    }
}
