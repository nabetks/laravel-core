<?php

namespace Aijoh\Core\Support\Trait;

trait UnicodeHorizontalBarExtender
{
    use UnicodeExtendPattern;

    /**
     * 横棒の正規表現の追加
     */
    public static function replaceHorizontalBarPattern(string $replace, string $str): string
    {
        $replace = '['.implode('', self::$horizontalBarList).']';

        return str_replace(self::$horizontalBarPattern, $replace, $str);
    }

    /**
     * 横棒の置換を行う
     */
    public static function replaceHorizontalBar(string $replace, string $str): string
    {
        return str_replace(self::$horizontalBarList, $replace, $str);
    }

    /**
     * 横棒の削除を行う
     */
    public static function removeHorizontalBar(string $str): string
    {
        return str_replace(self::$horizontalBarList, '', $str);
    }

    public static function splitHorizontalBar(string $str): array
    {
        return self::split('/[[:all-bar:]]++/u', $str);
    }


    public static function isHorizontalBar(string $str): bool
    {
        return self::i('/[[:all-bar:]]/u', $str);
    }
}
