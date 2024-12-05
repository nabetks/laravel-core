<?php

namespace Aijoh\Core\Rules;

class MS932ByteBetweenRule extends EncodeByteBetweenRule
{
    public function __construct(int $min, int $max)
    {
        parent::__construct('MS932', $min, $max);
    }
}
