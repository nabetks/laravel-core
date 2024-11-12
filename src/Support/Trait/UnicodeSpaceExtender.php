<?php

namespace Aijoh\Core\Support\Trait;

trait UnicodeSpaceExtender
{
    use UnicodeExtendPattern;

    /**
     * 文字列の前後の空白を削除する。
     */
    public static function trimSpace(string $str): string
    {
        return self::replace('/\A[[:all-space:]]++|[[:all-space:]]++\z/u', '', $str);
    }

    /**
     * 文字列の前の空白を削除する。
     */
    public static function ltrimSpace(string $str): string
    {
        return self::replace('/\A[[:all-space:]]++/u', '', $str);
    }

    /**
     * 文字列の後の空白を削除する。
     */
    public static function rtrimSpace(string $str): string
    {
        return self::replace('/[[:all-space:]]++\z/u', '', $str);
    }

    /**
     * 空白文字を全て削除する
     */
    public static function removeSpace(string $str): string
    {
        return self::replace('/[[:all-space:]]++/u', '', $str);
    }

    /**
     * 文字列の空白を置換する。
     */
    public static function replaceSpace(string $replace, string $str): string
    {
        return self::replace('/[[:all-space:]]++/u', $replace, $str);
    }

    /**
     * 文字列を空白で分割する。
     */
    public static function splitSpace(string $str): array
    {
        return self::split('/[[:all-space:]]++/u', $str);
    }
}
