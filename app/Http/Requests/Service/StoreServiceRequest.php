<?php

namespace App\Http\Requests\Service;

use App\Rules\UniqueForUser;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'designation' => ['required', new UniqueForUser("services", "designation")],
            'price' => 'required|numeric|decimal:0,2',
        ];
    }
}
