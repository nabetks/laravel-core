<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Support\Japanese;

class EncodeToMS932Rule {
    /**
     * 独自ルールを設定する。
     */
    protected function customRule(string $attribute, mixed $value, \Closure $fail): void {
        if( ! Japanese::isEncodableToMs932($value)  ){
            $fail('aijoh-validation.encode_to_ms932')->trnslate();
        }
    }
}
