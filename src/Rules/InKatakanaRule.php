<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\BaseRule;
use Aijoh\Core\Support\Japanese;

class InKatakanaRule extends BaseRule
{
    protected function customRule(string $attribute, mixed $value, \Closure $fail): void
    {
        if (! Japanese::inKatakana($value)) {
            $fail('aijoh-validation.in_katakana')->translate();
        }
    }
}
