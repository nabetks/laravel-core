<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Support\Japanese;
use Illuminate\Contracts\Validation\ValidationRule;

class InKatakana implements ValidationRule
{
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (!Japanese::inKatakana($value)) {
            $fail('aijoh-validation.in_katakana')->translate();
        }
    }

}
