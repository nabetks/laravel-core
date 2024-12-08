<?php

namespace Aijoh\Core\Rules;

class EucJpByteBetweenRule extends EncodeByteBetweenRule
{
    public function __construct(int $min, int $max)
    {
        parent::__construct('EUC-JP', $min, $max);
    }
}
