<?php

namespace Aijoh\Core\Macro\MixIn;

use Aijoh\Core\Support\Japanese;
use Aijoh\Core\Support\Unicode;

class StrMixin {
    /**
     * 英数字記号は半角に、カタカナは全角に変換する。
     */
    public static function normalize() : \Closure {
        return function( string $str ) : string {
            return Japanese::normalize($str);
        };
    }

    /**
     * UTF-8の文字列を指定したエンコーディングに変換する。
     */
    public static function encodeTo() : \Closure {
        return function( string $str, string $encode ) : string {
            return Japanese::encodeTo($str, $encode);
        };
    }

    /**
     * 指定のエンコードの文字列をUTF-8に変換する
     */
    public static function encodeFrom() : \Closure {
        return function( string $str, string $encode ) : string {
            return Japanese::encodeForm($str, $encode);
        };
    }

    /**
     * UTF-8の文字列をMS932に変換する
     */
    public static function encodeToMs932() : \Closure {
        return function( string $str ) : string {
            return Japanese::encodeToMs932($str);
        };
    }

    /**
     * MS932の文字列をUTF-8に変換する
     */
    public static function encodeFromMs932() : \Closure {
        return function( string $str ) : string {
            return Japanese::encodeFromMs932($str);
        };
    }

    /**
     * UTF-8の文字列をEUC-JPに変換する
     */
    public static function encodeToEucJp() : \Closure {
        return function( string $str ) : string {
            return Japanese::encodeFromEucJp($str);
        };
    }

    /**
     * EUC-JPの文字列をUTF-8に変換する
     */
    public static function encodeFromEucJp() : \Closure {
        return function( string $str ) : string {
            return Japanese::encodeFromEucJp($str);
        };
    }


    /**
     * 全角・半角カタカナをひらがなに変換する
     * @return \Closure
     */
    public static function toHiragana() : \Closure {
        return function( string $str ) : string {
            return Japanese::toHiragana($str);
        };
    }

    /**
     * ひらがなを全角カタカナに変換する
     * @return \Closure
     */
    public static function toKatakana() : \Closure {
        return function( string $str ) : string {
            return Japanese::toKatakana($str);
        };
    }

    /**
     * ひらがなのみ判定
     * @return \Closure
     */
    public static function isHiragana() : \Closure {
        return function( string $str ) : bool {
            return Japanese::isHiragana($str);
        };
    }

    /**
     * カタカナのみ判定
     * @return \Closure
     */
    public static function isKatakana() : \Closure {
        return function( string $str ) : bool {
            return Japanese::isKatakana($str);
        };
    }

    /**
     * 日本語の文字列か判定
     * @return \Closure
     */
    public static function isJapanese() : \Closure {
        return function( string $str ) : bool {
            return Japanese::isJapanese($str);
        };
    }


    /**
     * 文字列にひらがなが含まれている場合はtrueを返す
     */
    public static function inHiragana() : \Closure {
        return function( string $str ) : bool {
            return Japanese::inHiragana($str);
        };
    }

    /**
     * 文字列にカタカナが含まれている場合はtrueを返す
     */
    public static function inKatakana() : \Closure {
        return function( string $str ) : bool {
            return Japanese::inKatakana($str);
        };
    }

    /**
     * 文字列にひらがな・カタカナ・漢字が含まれている場合はtrueを返す
     */
    public static function inJapanese() : \Closure {
        return function( string $str ) : bool {
            return Japanese::inJapanese($str);
        };
    }

    /**
     * 文字列の前後の空白を削除する。
     */
    public static function trimSpace() : \Closure {
        return function( string $str ) : string {
            return Unicode::trimSpace($str);
        };
    }

    /**
     * 文字列の前の空白を削除する。
     * @return \Closure
     */
    public static function ltrimSpace() : \Closure {
        return function( string $str ) : string {
            return Unicode::ltrimSpace($str);
        };
    }

    /**
     * 文字列の後の空白を削除する。
     * @return \Closure
     */
    public static function rtrimSpace() : \Closure {
        return function( string $str ) : string {
            return Unicode::rtrimSpace($str);
        };
    }

    /**
     * 空白文字を全て削除する
     * @return \Closure
     */
    public static function removeSpace() : \Closure {
        return function( string $str ) : string {
            return Unicode::removeSpace($str);
        };
    }

    /**
     * 空白文字を一括で変換する。
     * @return \Closure
     */
    public static function replaceSpace() : \Closure {
        return function( string $replace, string $str ) : string {
            return Unicode::replaceSpace($replace, $str);
        };
    }

    /**
     * 空白で分割する
     * @return \Closure
     */
    public static function splitSpace() : \Closure {
        return function( string $str ) : array {
            return Unicode::splitSpace($str);
        };
    }

    /**
     * 水平方向の棒を置換する
     * @return \Closure
     */
    public static function replaceHorizontalBar() : \Closure {
        return function( string $str, string $replace ) : string {
            return Unicode::replaceHorizontalBar($str, $replace);
        };
    }

    /**
     * 水平方向の棒を削除する
     * @return \Closure
     */
    public static function removeHorizontalBar(  ) : \Closure {
        return function( string $str ) : string {
            return Unicode::removeHorizontalBar($str);
        };
    }

    public static function splitHorizontalBar() : \Closure {
        return function( string $str ) : array {
            return Unicode::splitHorizontalBar($str);
        };
    }
}
