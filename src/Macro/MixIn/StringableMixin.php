<?php

declare(strict_types=1);

namespace Aijoh\Core\Macro\MixIn;

use Aijoh\Core\Support\Japanese;
use Aijoh\Core\Support\Unicode;
use Illuminate\Support\Stringable;

class StringableMixin
{
    protected string $value;

    /**
     * ひらがな、カタカナ、半角カタカナを全角カタカナに変換
     */
    public function normalize(): \Closure
    {
        return function (): Stringable {
            return new Stringable(Japanese::normalize($this->value));
        };
    }

    /**
     * UTF-8の文字列を指定したエンコーディングに変換する。
     */
    public function encodeTo(): \Closure
    {
        return function (string $str, string $encode): Stringable {
            return new Stringable(Japanese::encodeTo($str, $encode));
        };
    }

    /**
     * 指定のエンコードの文字列をUTF-8に変換する
     */
    public function encodeFrom(): \Closure
    {
        return function (string $str, string $encode): Stringable {
            return new Stringable(Japanese::encodeForm($str, $encode));
        };
    }

    /**
     * UTF-8の文字列をMS932に変換する
     */
    public function encodeToMs932(): \Closure
    {
        return function (string $str): Stringable {
            return new Stringable(Japanese::encodeToMs932($str));
        };
    }

    /**
     * MS932の文字列をUTF-8に変換する
     */
    public function encodeFromMs932(): \Closure
    {
        return function (string $str): Stringable {
            return new Stringable(Japanese::encodeFromMs932($str));
        };
    }

    /**
     * UTF-8の文字列をEUC-JPに変換する
     */
    public function encodeToEucJp(): \Closure
    {
        return function (string $str): Stringable {
            return new Stringable(Japanese::encodeFromEucJp($str));
        };
    }

    /**
     * EUC-JPの文字列をUTF-8に変換する
     */
    public function encodeFromEucJp(): \Closure
    {
        return function (string $str): Stringable {
            return new Stringable(Japanese::encodeFromEucJp($str));
        };
    }

    /**
     * 全角・半角カタカナをひらがなに変換する
     */
    public function toHiragana(): \Closure
    {
        return function (string $str): Stringable {
            return new Stringable(Japanese::toHiragana($str));
        };
    }

    /**
     * 全角・半角カタカナをひらがなに変換する
     */
    public function toKatakana(): \Closure
    {
        return function (string $str): Stringable {
            return new Stringable(Japanese::toKatakana($str));
        };
    }

    /**
     * ひらがなのみの文字列かどうかの判別
     */
    public function isHiragana(): \Closure
    {
        return function (): bool {
            return Japanese::isHiragana($this->value);
        };
    }

    /**
     * カタカナのみの文字列かどうかの判別
     */
    public function isKatakana(): \Closure
    {
        return function (): bool {
            return Japanese::isKatakana($this->value);
        };
    }

    /**
     * 日本語のみの文字列かどうかの判別
     */
    public function isJapanese(): \Closure
    {
        return function (): bool {
            return Japanese::isJapanese($this->value);
        };

    }

    /**
     * 文字列にひらがなが含まれている場合はtrueを返す
     */
    public function inHiragana(): \Closure
    {
        return function (): bool {
            return Japanese::inHiragana($this->value);
        };
    }

    /**
     * 文字列にカタカナが含まれている場合はtrueを返す
     */
    public function inKatakana(): \Closure
    {
        return function (): bool {
            return Japanese::inKatakana($this->value);
        };
    }

    /**
     * 文字列にひらがな・カタカナ・漢字が含まれている場合はtrueを返す
     */
    public function inJapanese(): \Closure
    {
        return function (): bool {
            return Japanese::inJapanese($this->value);
        };
    }

    /**
     * 文字列の前後の空白を削除する。
     */
    public function trimSpace(): \Closure
    {
        return function (): Stringable {
            return new Stringable(Unicode::trimSpace($this->value));
        };
    }

    /**
     * 文字列の前の空白を削除する。
     */
    public function ltrimSpace(): \Closure
    {
        return function (): Stringable {
            return new Stringable(Unicode::ltrimSpace($this->value));
        };
    }

    /**
     * 文字列の後の空白を削除する。
     */
    public function rtrimSpace(): \Closure
    {
        return function (): Stringable {
            return new Stringable(Unicode::rtrimSpace($this->value));
        };
    }

    /**
     * 空白文字を全て削除する
     */
    public function removeSpace(): \Closure
    {
        return function (): Stringable {
            return new Stringable(Unicode::removeSpace($this->value));
        };
    }

    /**
     * 空白文字を一括で変換する。
     */
    public function replaceSpace(): \Closure
    {
        return function (string $replace): Stringable {
            return new Stringable(Unicode::replaceSpace($replace, $this->value));
        };
    }

    /**
     * 空白文字で分割する
     */
    public function splitSpace(): \Closure
    {
        return function (): array {
            return Unicode::splitSpace($this->value);
        };
    }

    /**
     * 水平方向の棒を置換する
     */
    public function replaceHorizontalBar(): \Closure
    {
        return function (string $replace): Stringable {
            return new Stringable(Unicode::replaceHorizontalBar($replace, $this->value));
        };
    }

    /**
     * 水平方向の棒を削除する
     */
    public function removeHorizontalBar(): \Closure
    {
        return function (): Stringable {
            return new Stringable(Unicode::removeHorizontalBar($this->value));
        };
    }

    /**
     * 水平方向の棒で分割する
     */
    public static function splitHorizontalBar(): \Closure
    {
        return function (): array {
            return Unicode::splitHorizontalBar($this->value);
        };
    }
}
