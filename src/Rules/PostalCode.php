<?php

namespace Aijoh\Core\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class PostalCode implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $val = (string) Str::of($value)->removeHorizontalBar()->normalize();
        if (! preg_match('/^\d{7}$/', $val)) {
            $fail('aijoh-validation.postal_code')->translate();
        }
    }
}
