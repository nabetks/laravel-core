<?php

namespace Aijoh\Core\ValueObjects;

use Illuminate\Support\Facades\Str;

class Boolean extends BaseObject
{
    protected static $falseList = [
        'false',
        '0',
        'off',
        'no',
        'n',
        'f',
        '',
        null,
        0,
        false,
    ];

    public static function beforeValidate(mixed $value): mixed
    {
        if (is_string($value)) {
            return (string) Str::of($value)->trimSpace()->lower();
        }

        return $value;
    }

    /**
     * バリデーション前のデータ変更を行う
     */
    public function formatValue(mixed $value): mixed
    {
        return match ($value) {
            is_bool($value) => $value,
            is_null($value) => false,
            is_float($value) => $value !== 0.0,
            is_int($value) || is_numeric($value) => (int) $value !== 0,
            is_string($value) => Str::of($value)->trimSpace()->lower()->in(static::$falseList),
            default => false,
        };
    }

    /**
     * 値を取得する
     */
    public function value(): mixed
    {
        return (bool) $this->value;
    }

    /**
     * 文字列を取得する
     */
    public function __toString(): string
    {
        return $this->value() ? 'true' : 'false';
    }
}
