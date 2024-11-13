<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\RuleBase;
use Illuminate\Support\Str;

class PostalCode extends RuleBase
{
    protected function customRule(string $attribute, mixed $value, \Closure $fail): void
    {
        $val = (string) Str::of($value)->removeHorizontalBar()->normalize();
        if (! preg_match('/^\d{7}$/', $val)) {
            $fail('aijoh-validation.postal_code')->translate();
        }
    }
}
