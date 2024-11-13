<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\RuleBase;
use Illuminate\Support\Str;

class PhoneNumberRule extends RuleBase
{
    protected function customRule(string $attribute, mixed $value, \Closure $fail): void
    {
        $phone = Str::of($value)->removeHorizontalBar()->normalize()->replace(['(', ')'], '');
        if (! preg_match('/^0\d{9,10}$/', $phone)) {
            $fail('aijoh-validation.phone_number')->translate();
        }
    }
}
