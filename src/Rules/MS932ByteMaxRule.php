<?php

namespace Aijoh\Core\Rules;

class MS932ByteMaxRule extends EncodeByteMaxRule
{
    public function __construct(int $max)
    {
        parent::__construct('MS932', $max);
    }
}
