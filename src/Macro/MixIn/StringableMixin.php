<?php

namespace Aijoh\Core\Macro\MixIn;

use Illuminate\Support\Stringable;
use Aijoh\Core\Support\Japanese;

class StringableMixin {

    /**
     * ひらがな、カタカナ、半角カタカナを全角カタカナに変換
     * @return \Closure
     */
    public function normalize() : \Closure {
        return function() : Stringable {
            return new Stringable(Japanese::normalize($this->value));
        };
    }


    /**
     * ひらがなをカタカナに変換
     * @return \Closure
     */
    public function toKatakana() : \Closure {
        return function() : Stringable {
            return new Stringable(Japanese::toKatakana($this->value));
        };
    }


    /**
     * カタカナをひらがなに変換
     * @return \Closure
     */
    public function toHiragana() : \Closure {
        return function() : Stringable {
            return new Stringable(Japanese::toHiragana($this->value));
        };
    }


    /**
     * 文字列にひらがなが含まれている場合はtrueを返す
     * @return \Closure
     */
    public function inHiragana() : \Closure {
        return function() : bool {
            return Japanese::inHiragana($this->value);
        };
    }

    /**
     * 文字列にカタカナが含まれている場合はtrueを返す
     * @return \Closure
     */
    public function inKatakana() : \Closure {
        return function() : bool {
            return Japanese::inKatakana($this->value);
        };
    }


    /**
     * 文字列に日本語が含まれている場合はtrueを返す
     * @return \Closure
     */
    public function inJapanese() : \Closure {
        return function() : bool {
            return Japanese::inJapanese($this->value);
        };
    }
}
