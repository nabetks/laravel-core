<?php

namespace Aijoh\Core\Rules;

class EucJpByteMaxRule extends EncodeByteMaxRule
{
    public function __construct(int $max)
    {
        parent::__construct('EUC-JP', $max);
    }
}
