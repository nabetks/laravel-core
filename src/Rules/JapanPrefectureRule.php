<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\BaseRule;
use Aijoh\Core\ValueObjects\Japan\JapanPrefecture as JapanPrefectureEntity;

class JapanPrefectureRule extends BaseRule
{
    protected function customRule(string $attribute, mixed $value, \Closure $fail): void
    {
        $result = JapanPrefectureEntity::make($value);
        if ($result === null) {
            $fail('aijoh-validation.prefecture')->translate();
        }
    }
}
