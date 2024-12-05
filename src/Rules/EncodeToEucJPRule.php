<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\BaseRule;
use Aijoh\Core\Support\Japanese;

class EucJPEncodableRule extends BaseRule
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 独自ルールを設定する。
     */
    protected function customRule(string $attribute, mixed $value, \Closure $fail): void
    {
        if (! Japanese::isEncodableToMs932($value)) {
            $fail($attribute.'はEUC-JPにエンコードできません。');
        }
    }
}
