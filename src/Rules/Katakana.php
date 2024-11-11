<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Support\Japanese;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Katakana implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Japanese::isKatakana($value)) {
            $fail('aijoh-validation.katakana')->translate();
        }
    }
}
