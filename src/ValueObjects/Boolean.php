<?php

namespace Aijoh\Core\ValueObjects;

use Illuminate\Support\Str;

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
        if (is_bool($value)) {
            return (bool) $value;
        }

        if (is_null($value)) {
            return false;
        }

        if (is_int($value)) {
            return (bool) $value;
        }

        if (is_string($value)) {
            $format = (string) Str::of($value)->trimSpace()->lower();

            return static::isFalseString($format) ? false : true;
        }

        logger()->info("boolean 判別の不明な型です: $value");

        return false;
    }

    /**
     * 文字列がfalseに該当するかをチェックする。
     */
    protected static function isFalseString(string $value): bool
    {
        return in_array($value, static::$falseList);
    }

    /**
     * バリデーション前のデータ変更を行う
     */
    public function formatValue(mixed $value): mixed
    {
        return static::beforeValidate($value);
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
