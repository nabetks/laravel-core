<?php

namespace Aijoh\Core\Support;


use Aijoh\Core\Support\Trait\UnicodePatternExtender;

class Unicode {
    use UnicodePatternExtender;

    /**
     * 文字列の前後の空白を削除する。
     * @param string $str
     * @return string
     */
    public static function trimSpace( string $str ) : string  {
        return self::replace('/\A[[:all-space:]]+|[[:all-space:]]+\z/', '', $str);
    }

    /**
     * 文字列の前の空白を削除する。
     * @param string $str
     * @return string
     */
    public static function ltrimSpace( string $str ) : string  {
        return self::replace('/\A[[:all-space:]]+/', '', $str);
    }

    /**
     * 文字列の後の空白を削除する。
     * @param string $str
     * @return string
     */
    public static function rtrimSpace( string $str ) : string {
        return self::replace('/[[:all-space:]]+\z/', '', $str);
    }



    public static function replaceSpace( string $str ) : string {
        return self::replace('/[[:all-space:]]+/', ' ', $str);
    }



}
