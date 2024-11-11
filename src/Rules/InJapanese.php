<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Support\Japanese;
use Illuminate\Contracts\Validation\ValidationRule;

class InJapanese implements ValidationRule
{
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (Japanese::inJapanese($value)) {
            $fail('aijoh-validation.in_japanese')->translate();
        }

    }
}
