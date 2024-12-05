<?php

namespace Aijoh\Core\Support;

use Aijoh\Core\Exception\EncodingException;

class Japanese
{
    /**
     * 全角英数字記号を半角、半角カナを全角カナに変換する
     */
    public static function normalize(string $value): string
    {
        $value = self::appendFullToHalf($value);
        $value = \Normalizer::normalize($value, \Normalizer::FORM_C);
        $value = mb_convert_kana($value, 'asKV', 'UTF-8');

        return Unicode::replace('/[[:all-space:]]/u', ' ', $value);
    }

    /**
     * mb_convert_kanaで対応出来ない全角英数字記号を半角に変換する
     */
    private static function appendFullToHalf(string $value): string
    {
        static $replace = [
            '＂' => '"',
            '”' => '"',
            '＇' => "'",
            '’' => "'",
            '￥' => '\\',
            '‘' => '`',
            '＼' => '\\',
        ];

        return str_replace(array_keys($replace), array_values($replace), $value);
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
        return static::encodeTo($value, 'MS932');
    }

    /**
     * Shift_JISの文字列をUTF-8に変換する
     *
     * @param  string  $value  Shift_JISの文字列
     */
    public static function encodeFromMs932(string $value): string
    {
        return static::encodeForm($value, 'MS932');
    }

    /**
     * UTF-8の文字列をEUC-JPに変換する
     */
    public static function encodeToEucJp(string $value): string
    {
        return static::encodeTo($value, 'EUC-JP');
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
     * また、合成文字は1文字に変換する。
     *
     * @param  string  $value  元の文字列
     * @return string 変換後の文字列
     */
    public static function toHiragana(string $value): string
    {
        $str = \Normalizer::normalize($value, \Normalizer::FORM_C);
        $str = mb_convert_kana($str, 'cHV', 'UTF-8');

        return str_replace(['ヴ', 'う゛'], ['ゔ', 'ゔ'], $str);
    }

    /**
     * 半角または全角のひらがなの文字列を全角カタカナに変換する。
     */
    public static function toKatakana(string $value): string
    {
        $result = \Normalizer::normalize($value, \Normalizer::FORM_C);
        $result = mb_convert_kana($result, 'CKV', 'UTF-8');

        return str_replace('ゔ', 'ヴ', $result);
    }

    /**
     * 指定した文字列がひらがなのみで構成されているか判別する
     *
     * @param  string  $value  判定する文字列
     * @return bool ひらがなのみで構成されている場合はtrue、それ以外はfalse
     */
    public static function isHiragana(string $value): bool
    {
        return preg_match('/\A\p{Hiragana}+\z/u', $value) === 1;
    }

    /**
     * 指定した文字列がカタカナのみで構成されているか判別する
     *
     * @param  string  $value  判定する文字列
     * @return bool カタカナのみで構成されている場合はtrue、それ以外はfalse
     */
    public static function isKatakana(string $value): bool
    {
        return preg_match('/\A\p{Katakana}+\z/u', $value) === 1;
    }

    /**
     * 指定した文字列が日本語(ひらがな、カタカナ、漢字)のみで構成されているか判別する。
     * ※空白文字は含まれない
     */
    public static function isJapanese(string $value): bool
    {
        return Unicode::match('/\A[\p{Hiragana}\p{Katakana}\p{Han}]+\z/u', $value);
    }

    /**
     * 指定した文字列にひらがなが含まれているか判別する
     *
     * @param  string  $value  判定する文字列
     * @return bool ひらがなが含まれている場合はtrue、それ以外はfalse
     */
    public static function inHiragana(string $value): bool
    {
        return preg_match('/\p{Hiragana}+/u', $value) === 1;
    }

    /**
     * 指定した文字列にカタカナが含まれているか判別する
     *
     * @param  string  $value  判定する文字列
     * @return bool カタカナが含まれている場合はtrue、それ以外はfalse
     */
    public static function inKatakana(string $value): bool
    {
        return preg_match('/\p{Katakana}+/u', $value) === 1;
    }

    /**
     * 指定した文字列に漢字が含まれているか判別する
     *
     * @param  string  $value  判定する文字列
     * @return bool 漢字が含まれている場合はtrue、それ以外はfalse
     */
    public static function inKanji(string $value): bool
    {
        return preg_match('/\p{Han}+/u', $value) === 1;
    }

    /**
     * 文字列に日本語(ひらがな、カタカナ、漢字)が含まれているか
     *
     * @param  string  $value  日本語が含まれているか調べる文字列
     */
    public static function inJapanese(string $value): bool
    {
        return preg_match('/\p{Hiragana}|\p{Katakana}|\p{Han}/u', $value) === 1;
    }

    /**
     * UTF-8の文字列がShift_JISに変換可能か判定する
     */
    public static function isEncodableToMs932(string $value): bool
    {
        return self::isEncodable($value, 'SJIS-win');
    }

    /**
     * UTF-8の文字列がShift_JISに変換可能か判定する
     */
    public static function isEncodableToEucJp(string $value): bool
    {
        return self::isEncodable($value, 'EUC-JP');
    }

    /**
     * UTF-8の文字列が指定のエンコードに変換可能か判定する
     *
     * @param  string  $value  変換する文字列
     * @param  string  $encode  変換先のエンコード
     * @return bool 全て変換可能な文字の場合はtrue 変換不可能な文字が入っていた場合はfalse
     */
    private static function isEncodable(string $value, string $encode): bool
    {
        $encodeString = self::encodeTo($value, $encode);
        return $value === self::encodeForm($encodeString, $encode);
    }


    /**
     * 指定のエンコードの文字列をUTF-8に変換する
     * @param string $value UTF-8の文字列
     * @param string $encode 変換後のエンコード
     * @return int バイト数
     * @throws EncodingException
     */
    public static function getEncodeByte(string $value,string $encode) : int {
        $from = static::encodeTo($value, $encode);
        $reEncodeString = static::encodeForm($from, $encode);

        if( $reEncodeString !== $from ) {
            throw new EncodingException("UTF-8",$encode);
        }

        return strlen($from);
    }
}
