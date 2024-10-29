<?php

namespace Aijoh\Core\Macro\MixIn;

use Aijoh\Core\Macro\MixIn\Trait\UnicodeSpacePattern;
use Closure;

class Japanese
{
    use UnicodeSpacePattern;

    public static function normalize(): Closure
    {
        return function (string $value): string {
            $value = mb_convert_kana($value, 'asKV', 'UTF-8');
            $value = str_replace(['＂', '＇', '￥', '＼'], ['"', "'", '\\', '\\'], $value);

            return preg_replace(self::replaceSpacePattern('/[[:all-space:]]/u'), ' ', $value);
        };
    }

    /**
     * UTF-8から指定した文字コードに変換する
     */
    private static function encodeFromUtf8(string $str, string $from): string
    {
        return mb_convert_encoding($str, $from, 'UTF-8');
    }

    /**
     * 文字をUTF-8から指定した文字コードに変換する
     *
     * @param  string  $to  UTF-8から変換する文字コード
     */
    public static function encodeTo(): Closure
    {
        return function (string $str, string $to): string {
            return mb_convert_encoding($str, $to, 'UTF-8');
        };
    }
}
