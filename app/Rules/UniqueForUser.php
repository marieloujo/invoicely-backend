<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueForUser implements ValidationRule
{

    private $table;
    private $column;
    private $except;

    public function __construct(string $table, string $column, string $except = null) {
        $this->table = $table;
        $this->column = $column;
        $this->except = $except;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = DB::table($this->table)
                            ->where($this->column, $value)
                            ->where("user_id", auth('api')->id());

        if ($this->except) {
            $query = $query->whereNot("id", $this->except);
        }

        $existingData = $query->exists();

        if ($existingData) {
            $fail('The :attribute must be unique.');
        }
    }
}
