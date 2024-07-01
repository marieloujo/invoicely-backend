<?php

namespace App\Http\Requests\Service;

use App\Rules\UniqueForUser;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'designation' => ['sometimes', new UniqueForUser("services", "designation", $this->route('service')->id)],
            'prix' => 'sometimes|numeric|decimal:0,2',
        ];
    }
}
