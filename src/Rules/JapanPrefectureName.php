<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\ValueObjects\Japan\JapanPrefecture as Prefecture;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * 日本語の都道府県が正しく入力されているかチェックを行う。
 */
class JapanPrefectureName implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $prefecture = Prefecture::makeFromJapanese($value);
        if ($prefecture === null) {
            $fail('aijoh-validation.prefecture')->translate();
        }
    }
}
