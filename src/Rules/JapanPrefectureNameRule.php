<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\RuleBase;
use Aijoh\Core\ValueObjects\Japan\JapanPrefecture as Prefecture;

/**
 * 日本語の都道府県が正しく入力されているかチェックを行う。
 */
class JapanPrefectureNameRule extends RuleBase
{
    protected function customRule(string $attribute, mixed $value, \Closure $fail): void
    {
        $prefecture = Prefecture::makeFromJapanese($value);
        if ($prefecture === null) {
            $fail('aijoh-validation.prefecture')->translate();
        }
    }
}
