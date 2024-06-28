<?php

namespace App\Http\Requests\Product;

use App\Rules\UniqueForUser;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'designation' => ['sometimes', new UniqueForUser("products", "designation", $this->route('product')->id)],
            'lower_limit' => 'sometimes|numeric|min:1',
            'stock' => 'sometimes|numeric|min:1',
            'price' => 'sometimes|numeric|decimal:0,2'
        ];
    }
}
