<?php

namespace Aijoh\Core\Macro\MixIn;

use Aijoh\Core\Macro\MixIn\Trait\UnicodeSpacePattern;
use Closure;
use Aijoh\Core\Support\Japanese;


class StrMixin {

    /**
     *
     * @return Closure
     */
    public static function normalize() : \Closure {
        return function(string $str) : string {
            return Japanese::normalize($str);
        };
    }


    public static function toHiragana() : \Closure {
        return function(string $str) : string {
            return Japanese::toHiragana($str);
        };
    }


    public static function toKatakana() : \Closure {
        return function(string $str) : string {
            return Japanese::toKatakana($str);
        };
    }


    


}
