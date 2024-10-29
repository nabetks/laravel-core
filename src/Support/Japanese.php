<?php

namespace Aijoh\Core\Support;

class Japanese
{
    /**
     * 全角英数字記号を半角、半角カナを全角カナに変換する
     */
    public static function normalize(string $value): string
    {
        $value = mb_convert_kana($value, 'asKV', 'UTF-8');
        $value = str_replace(['＂', '＇', '￥', '＼'], ['"', "'", '\\', '\\'], $value);

        return Unicode::replace('/[[:all-space:]]+/u', ' ', $value);
    }

    /**
     * UTF-8の文字列を指定のエンコードに変換する
     */
    public static function encodeTo(string $value, string $encode): string
    {
        return mb_convert_encoding($value, 'UTF-8', $encode);
    }

    /**
     * 指定のエンコードの文字列をUTF-8に変換する
     */
    public static function encodeForm(string $value, string $encode): string
    {
        return mb_convert_encoding($value, $encode, 'UTF-8');
    }

    /**
     *  UTF-8の文字列をShift_JISに変換する
     */
    public static function encodeToMs932(string $value): string
    {
        return static::encodeTo($value, 'SJIS-win');
    }

    /**
     * UTF-8の文字列をEUC-JPに変換する
     */
    public static function encodeToEucJp(string $value): string
    {
        return static::encodeTo($value, 'EUC-JP');
    }

    /**
     * Shift_JISの文字列をUTF-8に変換する
     *
     * @param  string  $encode
     */
    public static function encodeFromMs932(string $value): string
    {
        return static::encodeForm($value, 'SJIS-win');
    }

    /**
     * EUC-JPの文字列をUTF-8に変換する
     */
    public static function encodeFromEucJp(string $value): string
    {
        return static::encodeForm($value, 'EUC-JP');
    }

    /**
     * 半角または全角のカタカナの文字列を全角ひらがなに変換する。
     *
     * @param  string  $value  元の文字列
     * @return string 変換後の文字列
     */
    public static function toHiragana(string $value): string
    {
        $str = mb_convert_kana($value, 'cHV', 'UTF-8');

        return str_replace(['ヴ', 'う゛'], ['ゔ', 'ゔ'], $str);
    }

    /**
     * 半角または全角のひらがなの文字列を全角カタカナに変換する。
     */
    public static function toKatakana(string $value): string
    {
        $results = mb_convert_kana($value, 'CKV', 'UTF-8');

        return str_replace('ゔ', 'ヴ', $results);
    }

    /**
     * 文字列にひらがなが含まれているか
     */
    public static function inHiragana(string $value): bool
    {
        return preg_match('/\p{Hiragana}+/u', $value) === 1;
    }

    /**
     * 文字列にカタカナが含まれているか
     */
    public static function inKatakana(string $value): bool
    {
        return preg_match('/\p{Katakana}+/u', $value) === 1;
    }

    /**
     * 文字列に漢字が含まれているか
     */
    public static function hasKanji(string $value): bool
    {
        return preg_match('/\p{Han}+/u', $value) === 1;
    }

    /**
     * 文字列に日本語(ひらがな、カタカナ、漢字)が含まれているか
     *
     * @param  string  $value  日本語が含まれているか調べる文字列
     */
    public static function hasJapanese(string $value): bool
    {
        return preg_match('/\p{Hiragana}+|\p{Katakana}+|\p{Han}+/u', $value) === 1;
    }
}
