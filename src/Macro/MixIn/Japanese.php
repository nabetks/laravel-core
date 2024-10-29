<?php

namespace Aijoh\Core\Macro\MixIn;

use Aijoh\Core\Macro\MixIn\Trait\UnicodeSpacePattern;

class Japanese {
    use UnicodeSpacePattern;

    public function normalize(string $value) : string {
        $value = mb_convert_kana($value, 'asKV', 'UTF-8');
        $value = str_replace(['＂','＇','￥','＼'],['"',"'",'\\','\\'], $value);
        return preg_replace($this->replaceSpacePattern('/[[:all-space:]]/u'),' ',$value);
    }

    /**
     * 文字をUTF-8から指定した文字コードに変換する
     * @param string $str
     * @param string $to UTF-8から変換する文字コード
     * @return string
     */
    public function encodeTo( string $str, string $to ) : string {
        return mb_convert_encoding($str, $to, 'UTF-8');
    }


    /**
     * 文字をUTF-8からShift_JISに変換する
     * @param string $str
     * @return string
     */
    public function toMs932( string $str ) : string {
        return $this->encodeTo($str, 'SJIS-win');
    }

    /**
     * 文字をUTF-8からShift_JISに変換する
     * @param string $str
     * @return string
     */
    public function toEucJP( string $str ) : string {
        return $this->encodeTo($str, 'EUC-JP');
    }


    /**
     * 文字を指定した文字コードからUTF-8に変換する
     * @param string $str 文字コード
     * @param string $from UTF-8に変換する文字コード
     * @return string
     */
    public function encodeFrom( string $str, string $from ) : string {
        return mb_convert_encoding($str, 'UTF-8', $from);
    }


    /**
     * 文字をShift_JISからUTF-8に変換する
     * @param string $str
     * @return string
     */
    public function fromMs932( string $str ) : string {
        return $this->encodeFrom($str, 'SJIS-win');
    }

    /**
     * 文字をEUC-JPからUTF-8に変換する
     * @param string $str
     * @return string
     */
    public function fromEucJP( string $str ) : string {
        return $this->encodeFrom($str, 'EUC-JP');
    }

    /**
     * 半角または全角のカタカナの文字列を全角ひらがなに変換する。
     * @param string $value 元の文字列
     * @return string 変換後の文字列
     */
    public static function toHiragana( string $value ) : string {
        $str = mb_convert_kana($value, 'cHV', 'UTF-8');
        return str_replace([ 'ヴ', 'う゛' ], [ 'ゔ', 'ゔ' ], $str);
    }

    /**
     * 半角または全角のひらがなの文字列を全角カタカナに変換する。
     * @param string $value
     * @return string
     */
    public static function toKatakana( string $value ) : string {
        $results = mb_convert_kana($value, 'CKV', 'UTF-8');
        return str_replace('ゔ', 'ヴ', $results);
    }

    /*
    * 文字列にひらがなが含まれているか
    * @param string $value
    * @return bool
    */
    public function hasHiragana( string $value ) : bool {
        return preg_match('/\p{Hiragana}+/u', $value) === 1;
    }

    /**
     * 文字列にカタカナが含まれているか
     * @param string $value
     * @return bool
     */
    public function hasKatakana( string $value ) : bool {
        return preg_match('/\p{Katakana}+/u', $value) === 1;
    }

    /**
     * 文字列に漢字が含まれているか
     * @param string $value
     * @return bool
     */
    public function hasKanji( string $value ) : bool {
        return preg_match('/\p{Han}+/u', $value) === 1;
    }

    /**
     * 文字列に日本語(ひらがな、カタカナ、漢字)が含まれているか
     * @param string $value 日本語が含まれているか調べる文字列
     * @return bool
     */
    public function hasJapanese( string $value ) : bool {
        return preg_match('/\p{Hiragana}+|\p{Katakana}+|\p{Han}+/u', $value) === 1;
    }

}
