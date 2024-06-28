<?php

namespace App\Http\Requests\Product;

use App\Rules\UniqueForUser;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'designation' => ['required', new UniqueForUser("products", "designation")],
            'lower_limit' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'price' => 'required|numeric|decimal:0,2'
        ];
    }
}
