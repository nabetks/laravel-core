<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\BaseRule;
use Aijoh\Core\Support\Japanese;

class HiraganaRule extends BaseRule
{
    protected function customRule(string $attribute, mixed $value, \Closure $fail): void
    {
        if (! Japanese::isHiragana($value)) {
            $fail('aijoh-validation.hiragana')->translate();
        }
    }
}
