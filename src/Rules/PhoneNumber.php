<?php

namespace Aijoh\Core\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class PhoneNumber implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $phone = Str::of($value)->removeHorizontalBar()->normalize()->replace(['(', ')'], '');
        if (! preg_match('/^0\d{9,10}$/', $phone)) {
            $fail('aijoh-validation.phone_number')->translate();
        }
    }
}
