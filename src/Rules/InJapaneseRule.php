<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\BaseRule;
use Aijoh\Core\Support\Japanese;

class InJapaneseRule extends BaseRule
{
    protected function customRule(string $attribute, mixed $value, \Closure $fail): void
    {
        if (Japanese::inJapanese($value)) {
            $fail('aijoh-validation.in_japanese')->translate();
        }
    }
}
