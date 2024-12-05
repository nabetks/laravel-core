<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\BaseRule;
use Aijoh\Core\Support\Japanese;

class EncodeToEucJpRule extends BaseRule {

    /**
     * 独自ルールを設定する。
     */
    protected function customRule(string $attribute, mixed $value, \Closure $fail): void {
        if( ! Japanese::isEncodableToMs932($value)  ){
            $fail('aijoh-validation.encode_to_eucjp')->trnslate();
        }
    }

}
