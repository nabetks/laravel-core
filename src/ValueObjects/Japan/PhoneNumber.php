<?php

namespace Aijoh\Core\ValueObjects\Japan;

use Aijoh\Core\Rules\PhoneNumber as PhoneNumberRule;
use Aijoh\Core\ValueObjects\BaseObject;
use Illuminate\Support\Str;

/**
 * 日本国内の電話番号を表すクラスです。
 */
class PhoneNumber extends BaseObject
{
    private static array $japaneseInternationalPrefix = ['+81', '81'];

    /**
     * 電話番号を取得
     *
     * @param  string  $value  電話番号
     */
    #[\Override]
    public static function beforeValidate(mixed $value): mixed
    {
        $value = (string) Str::of($value)->removeHorizontalBar()->normalize()->replace(['-', '(', ')'], '');
        foreach (self::$japaneseInternationalPrefix as $prefix) {
            if (Str::startsWith($value, $prefix)) {
                $value = Str::replaceFirst($prefix, '0', $value);
                break;
            }
        }

        return $value;
    }

    /**
     * 電話番号の形式をチェック
     */
    public function getRules(): array
    {
        return [new PhoneNumberRule];
    }

    /**
     * 携帯電話の番号かどうかを判定
     */
    public function isMobile(): bool
    {
        return preg_match('/^0[6-9]0/', $this->value) === 1;
    }

    /**
     * 国際電話番号を取得
     */
    public function getInternationalPhoneNumber(): string
    {
        return '+81'.substr($this->value, 1);
    }
}
