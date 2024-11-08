<?php

namespace Aijoh\Core\Macro\MixIn;

use Aijoh\Core\Support\Japanese;
use Aijoh\Core\Support\Unicode;

class StrMixin
{
    /**
     * 英数字記号は半角に、カタカナは全角に変換する。
     */
    public static function normalize(): \Closure
    {
        return function (string $str): string {
            return Japanese::normalize($str);
        };
    }

    /**
     * 文字列をひらがなに変換する
     */
    public static function toHiragana(): \Closure
    {
        return function (string $str): string {
            return Japanese::toHiragana($str);
        };
    }

    /**
     * 文字列をカタカナに変換する
     */
    public static function toKatakana(): \Closure
    {
        return function (string $str): string {
            return Japanese::toKatakana($str);
        };
    }

    public static function isHiragana(): \Closure
    {
        return function (string $str): bool {
            return Japanese::isHiragana($str);
        };
    }

    /**
     * 文字列にひらがなが含まれている場合はtrueを返す
     */
    public static function inHiragana(): \Closure
    {
        return function (string $str): bool {
            return Japanese::inHiragana($str);
        };
    }

    /**
     * 文字列にカタカナが含まれている場合はtrueを返す
     */
    public static function inKatakana(): \Closure
    {
        return function (string $str): bool {
            return Japanese::inKatakana($str);
        };
    }

    /**
     * 文字列の前後の空白を削除する。
     */
    public static function splitBlank(): \Closure
    {
        return function (string $str): array {
            return Unicode::splitBlank($str);
        };
    }

    /**
     * 横棒の置換を行う
     */
    public static function replaceHorizontalBar(): \Closure
    {
        return function (string $replace, string $str): string {
            return Unicode::replaceHorizontalBar($replace, $str);
        };
    }

    /**
     * 横棒の削除を行う
     */
    public static function removeHorizontalBar(): \Closure
    {
        return function (string $str): string {
            return Unicode::replaceHorizontalBar('', $str);
        };
    }
}
