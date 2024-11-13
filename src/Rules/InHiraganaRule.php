<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\RuleBase;
use Aijoh\Core\Support\Japanese;

class InHiraganaRule extends RuleBase
{
    protected function customRule(string $attribute, mixed $value, \Closure $fail): void
    {
        if (Japanese::inHiragana($value)) {
            $fail('aijoh-validation.in_hiragana')->translate();
        }
    }
}
