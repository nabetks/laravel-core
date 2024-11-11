<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Support\Japanese;
use Illuminate\Contracts\Validation\ValidationRule;

class InHiragana implements ValidationRule
{
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (Japanese::inHiragana($value)) {
            $fail('aijoh-validation.in_hiragana')->translate();
        }

    }
}
