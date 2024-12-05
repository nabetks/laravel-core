<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\BaseRule;
use Aijoh\Core\Support\Japanese;

class KatakanaRule extends BaseRule
{
    protected function customRule(string $attribute, mixed $value, \Closure $fail): void
    {
        if (! Japanese::isKatakana($value)) {
            $fail('aijoh-validation.katakana')->translate();
        }
    }
}
