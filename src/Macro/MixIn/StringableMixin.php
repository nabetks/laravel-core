<?php

namespace Aijoh\Core\Macro\MixIn;

use Illuminate\Support\Stringable;
use Aijoh\Core\Support\Japanese;

class StringableMixin {

    public function normalize() : \Closure {
        return function() : Stringable {
            return new Stringable(Japanese::normalize($this->value));
        };
    }



}
