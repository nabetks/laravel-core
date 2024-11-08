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
     * ひらがなをカタカナに変換
     */
    public function toKatakana(): \Closure
    {
        return function (): Stringable {
            return new Stringable(Japanese::toKatakana($this->value));
        };
    }

    /**
     * カタカナをひらがなに変換
     */
    public function toHiragana(): \Closure
    {
        return function (): Stringable {
            return new Stringable(Japanese::toHiragana($this->value));
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
     * 文字列に日本語が含まれている場合はtrueを返す
     */
    public function inJapanese(): \Closure
    {
        return function (): bool {
            return Japanese::inJapanese($this->value);
        };
    }

    /**
     * 文字列の横棒を削除する
     * @return \Closure
     */
    public function removeHorizontalBar(): \Closure
    {
        return function (): Stringable {
            return new Stringable(Unicode::replaceHorizontalBar('', $this->value));
        };
    }

    /**
     * 横棒の置換を行う
     * @return \Closure
     */
    public function replaceHorizontalBar(): \Closure
    {
        return function (string $replace): Stringable {
            return new Stringable(Unicode::replaceHorizontalBar($replace, $this->value));
        };
    }
}
