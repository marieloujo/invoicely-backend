<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnsureProductQuantityIsEnough implements ValidationRule
{
    private $type;

    public function __construct(string $type) {
        $this->type = $type;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->type === 'products') {
            $product = Product::findOrFail($value['id']);

            if ($product->stock < $value['quantity']) {
                $fail('The stock is insufficient.');
            }
        }
    }
}
