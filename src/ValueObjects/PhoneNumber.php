<?php

namespace Aijoh\Core\ValueObjects;

/**
 * 日本国内の電話番号を表すクラスです。
 */
class PhoneNumber extends BaseObject {


    protected function beforeValidate($value) {

    }

    /**
     * 電話番号の形式をチェック
     * @return array|string|null
     */
    public function getRules() : array|string|null {
        return 'required|regex:/^0\d{9,10}$/';
    }

    /**
     * メッセージを取得
     * @return string[]
     */
    public function getMessages() : array {
        return [
            'regex' => '電話番号の形式が正しくありません。',
        ];
    }

    /**
     * 属性を取得
     * @return string
     */
    public function getAttribute() : string {
        return "電話番号";
    }


    /**
     * 携帯電話の番号かどうかを判定
     * @return bool
     */
    public function isMobile() : bool {
        return preg_match('/^0[789]0/', $this->value) === 1;
    }





    /**
     * 国際電話番号を取得
     * @return string
     */
    public function getInternationalPhoneNumber() : string {
        return '+81' . substr($this->value, 1);
    }
}
