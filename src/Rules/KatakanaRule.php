<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\RuleBase;
use Aijoh\Core\Support\Japanese;
use Aijoh\Core\ValueObjects\Japan\JapanPrefecture as JapanPrefectureEntity;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class KatakanaRule extends RuleBase {

    protected function customRule( string $attribute, mixed $value, \Closure $fail ) : void {
        if (! Japanese::isKatakana($value)) {
            $fail('aijoh-validation.katakana')->translate();
        }
    }
}
