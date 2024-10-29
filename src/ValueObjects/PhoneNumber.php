<?php

namespace Aijoh\Core\ValueObjects;

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
     * @return mixed
     */
    protected function beforeValidate($value)
    {
        $value = (string) Str::of($value)->normalize()->replace(['-', '(', ')'], '');
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
    public function getRules(): array|string|null
    {
        return 'required|regex:/^0\d{9,10}$/';
    }

    /**
     * メッセージを取得
     *
     * @return string[]
     */
    public function getMessages(): array
    {
        return [
            'regex' => '電話番号の形式が正しくありません。',
        ];
    }

    /**
     * 属性を取得
     */
    public function getAttribute(): string
    {
        return '電話番号';
    }

    /**
     * 携帯電話の番号かどうかを判定
     */
    public function isMobile(): bool
    {
        return preg_match('/^0[789]0/', $this->value) === 1;
    }

    /**
     * 国際電話番号を取得
     */
    public function getInternationalPhoneNumber(): string
    {
        return '+81'.substr($this->value, 1);
    }
}
