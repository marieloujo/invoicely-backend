<?php

namespace App\Http\Requests;

use App\Rules\EnsureProductQuantityIsEnough;
use Illuminate\Foundation\Http\FormRequest;

class StoreFactureRequest extends FormRequest
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
            'client' => [
                'id' => ['sometimes', 'uuid', 'exists:clients,id'],
                'email'         => 'required_if:client.id,null|email|unique:client,email',
                'first_name'    => 'required_if:client.id,null|string',
                'last_name'     => 'required_if:client.id,null|string',
                'adresse'       => 'required_if:client.id,null|string',
                'phone_number'  => 'required_if:client.id,null|numeric|unique:client,phone_number',
            ],
            'type'  => 'required|in:products,services',
            'items' => 'required|array',
            'items.*.id' => 'required|uuid|exists:'. $this->type .',id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*' => ['required', 'array', new EnsureProductQuantityIsEnough($this->type)],
        ];
    }
}
