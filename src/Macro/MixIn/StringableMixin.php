<?php

namespace Aijoh\Core\Macro\MixIn;

use Aijoh\Core\Support\Japanese;
use Illuminate\Support\Stringable;

class StringableMixin
{
    public function normalize(): \Closure
    {
        return function (): Stringable {
            return new Stringable(Japanese::normalize($this->value));
        };
    }
}
