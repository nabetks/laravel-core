<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\RuleBase;
use Aijoh\Core\ValueObjects\Japan\JapanPrefecture as JapanPrefectureEntity;

class JapanPrefectureRule extends RuleBase
{
    protected function customRule(string $attribute, mixed $value, \Closure $fail): void
    {
        $result = JapanPrefectureEntity::make($value);
        if ($result === null) {
            $fail('aijoh-validation.prefecture')->translate();
        }
    }
}
