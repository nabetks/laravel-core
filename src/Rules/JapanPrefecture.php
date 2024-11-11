<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\ValueObjects\Japan\JapanPrefecture as JapanPrefectureEntity;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class JapanPrefecture implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $result = JapanPrefectureEntity::make($value);
        if ($result === null) {
            $fail('aijoh-validation.prefecture')->translate();
        }
    }
}
