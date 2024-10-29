<?php

namespace Aijoh\Core\Macro\MixIn;

use Aijoh\Core\Macro\MixIn\Trait\UnicodeSpacePattern;
use Closure;
use Aijoh\Core\Support\Japanese;


class StrMixin {

    /**
     * 英数字記号は半角に、カタカナは全角に変換する。
     * @return Closure
     */
    public static function normalize() : \Closure {
        return function(string $str) : string {
            return Japanese::normalize($str);
        };
    }

    /**
     * 文字列をひらがなに変換する
     * @return Closure
     */
    public static function toHiragana() : \Closure {
        return function(string $str) : string {
            return Japanese::toHiragana($str);
        };
    }

    /**
     * 文字列をカタカナに変換する
     * @return Closure
     */
    public static function toKatakana() : \Closure {
        return function(string $str) : string {
            return Japanese::toKatakana($str);
        };
    }

    /**
     * 文字列にひらがなが含まれている場合はtrueを返す
     * @return Closure
     */
    public static function inHiragana() : \Closure {
        return function(string $str) : bool {
            return Japanese::inHiragana($str);
        };
    }

    /**
     * 文字列にカタカナが含まれている場合はtrueを返す
     * @return Closure
     */
    public static function inKatakana( ) : \Closure {
        return function(string $str) : bool {
            return Japanese::inKatakana($str);
        };
    }





}
