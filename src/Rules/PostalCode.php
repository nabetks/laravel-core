<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\BaseRule;
use Illuminate\Support\Str;

class PostalCode extends BaseRule
{
    protected function customRule(string $attribute, mixed $value, \Closure $fail): void
    {
        $val = (string) Str::of($value)->removeHorizontalBar()->normalize();
        if (! preg_match('/^\d{7}$/', $val)) {
            $fail('aijoh-validation.postal_code')->translate();
        }
    }
}
