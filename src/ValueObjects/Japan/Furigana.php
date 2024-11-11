<?php

namespace Aijoh\Core\ValueObjects\Japan;

use Aijoh\Core\Rules\Furigana as FuriganaRule;
use Aijoh\Core\ValueObjects\BaseObject;
use Illuminate\Support\Str;

/**
 * 氏名の読み仮名(ひらがな、カタカナ)を管理するクラスです
 */
class Furigana extends BaseObject
{
    /**
     * バリデーション前のデータ変換
     *
     * @return mixed
     */
    public static function beforeValidate($value)
    {
        return (string) Str::of($value)->trimSpace()->replaceSpace(' ')->normalize()->toHiragana();
    }

    /**
     * バリデーションルール
     */
    public function getRules(): array
    {
        return [new FuriganaRule];
    }
}
