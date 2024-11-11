<?php

namespace Aijoh\Core\ValueObjects\Japan;

use Aijoh\Core\Rules\PostalCode as PostalCodeRule;
use Aijoh\Core\ValueObjects\BaseObject;
use Illuminate\Support\Str;

class PostalCode extends BaseObject
{
    /**
     * 郵便番号のフォーマット
     *
     * @param  string  $value  郵便番号の文字列
     * @return string
     */
    public static function beforeValidate(mixed $value): mixed
    {
        return (string) Str::of($value)->removeHorizontalBar()->normalize();
    }

    /**
     * バリデーションルールの取得
     */
    public function getRules(): array
    {
        return [new PostalCodeRule];
    }

    public function getAttribute(): string
    {
        return '郵便番号';
    }

    /**
     * ハイフン付きの郵便番号を取得
     */
    public function getHyphenNumber(): string
    {
        return Str::substr($this->value, 0, 3).'-'.Str::substr($this->value, 3, 4);
    }
}
