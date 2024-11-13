<?php

namespace Aijoh\Core\ValueObjects;

use Aijoh\Core\Rules\EmailAddress;
use Illuminate\Support\Str;

class Email extends BaseObject
{
    /**
     * メールアドレスのフォーマット
     */
    public static function beforeValidate(mixed $value): mixed
    {
        return (string) Str::of($value)->normalize()->trimSpace();
    }

    /**
     * バリデーションルールの取得
     *
     * @return string[]
     */
    public function getRules(): array
    {
        return [
            new EmailAddress,
        ];
    }

    /**
     * メールアドレスのドメインを取得
     * @return string
     */
    public function getDomain() : string {
        return Str::of($this->value)->after('@')->toString();
    }


    /**
     * メールアドレスのローカルパートを取得
     * @return string
     */
    public function getLocalPart() : string {
        return Str::of($this->value)->before('@')->toString();
    }

}
