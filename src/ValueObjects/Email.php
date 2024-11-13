<?php
namespace Aijoh\Core\ValueObjects;

use Aijoh\Core\Rules\EmailAddress;
use Illuminate\Support\Str;

class Email extends BaseObject {

    /**
     * メールアドレスのフォーマット
     * @param mixed $value
     * @return mixed
     */
    public static function beforeValidate( mixed $value ) : mixed {
        return (string) Str::of($value)->normalize()->trimSpace();
    }

    /**
     * バリデーションルールの取得
     * @return string[]
     */
    public function getRules() : array {
        return [
            new EmailAddress()
        ];
    }

}
