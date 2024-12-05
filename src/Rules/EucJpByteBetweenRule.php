<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Exception\EncodingException;
use Aijoh\Core\Rules\Base\BaseRule;
use Aijoh\Core\Support\Japanese;
use Closure;

class EucJpByteBetweenRule extends EncodeByteBetweenRule
{
    public function __construct(int $min,int $max)
    {
        parent::__construct('EUC-JP', $min, $max);
    }

}
