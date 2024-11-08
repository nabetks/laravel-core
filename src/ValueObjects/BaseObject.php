<?php

namespace Aijoh\Core\ValueObjects;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BaseObject {

    /**
     * オブジェクトの値
     */
    protected mixed $value;

    /**
     * バリデーションキー
     */
    private static string $validateKey = 'value';

    final public function __construct( mixed $value, bool $isValidate = true ) {
        if ( $isValidate ) {
            $value = $this->validate($value);
        }
        $this->value = $this->formatValue($value);
    }

    /**
     * 入力した値を内部の値にフォーマットする
     */
    protected function formatValue( mixed $value ) : mixed {
        return $value;
    }

    /**
     * バリデーションせずにインスタンスを生成する
     */
    public static function makeForce( mixed $value ) : static {
        return new static($value, false);
    }

    /**
     * 入力値のチェックを行う。
     *
     * @param mixed $value 入力値
     * @return mixed チェック後の値
     *
     * @throws ValidationException バリデーション例外
     */
    protected function validate( mixed $value ) : mixed {
        $value = $this->beforeValidate($value);

        $rules = $this->getValidationRules(self::$validateKey);
        if ( empty($rules) ) {
            return $value;
        }
        $attributes = $this->getValidationAttribute(self::$validateKey);
        $messages = $this->getValidationMessages(self::$validateKey);

        $results = Validator::make([ self::$validateKey => $value ], $rules, $messages, $attributes)->validate();
        $value = $results[ self::$validateKey ];

        return $this->afterValidate($value);
    }

    /**
     * バリデーション前の処理
     *
     * @param mixed $value バリデーション前の処理
     * @return mixed
     */
    protected function beforeValidate( $value ) {
        return $value;
    }

    /**
     * バリデーション後の処理
     *
     * @param mixed $value
     * @return mixed
     */
    protected function afterValidate( $value ) {
        return $value;
    }

    /**
     * バリデーション属性の取得
     *
     * @param string $key キー
     * @param array $beforeRules 前のルール
     * @param array $afterRules 後のルール
     */
    final public function getValidationRules( string $key, array $beforeRules = [], array $afterRules = [] ) : array|string|null {
        $rules = $this->getRules();
        if ( is_string($rules) ) {
            $rules = explode('|', $rules);
        }

        $rules = array_merge($beforeRules, $rules, $afterRules);
        if ( empty($rules) ) {
            return null;
        }

        return [ $key => $rules ];
    }

    /**
     * バリデーション属性の取得
     *
     * @param string $key キー値
     * @param array $addMessages 追加のメッセージ
     */
    final public function getValidationMessages( string $key, array $addMessages = [] ) : array {
        $messages = array_merge($this->getMessages(), $addMessages);
        if ( empty($messages) ) {
            return [];
        }

        $results = [];
        foreach ( $messages as $key => $message ) {
            $results[ $key . '.' . $key ] = $message;
        }

        return $results;
    }

    final public function getValidationAttribute( string $key ) : array {
        $attribute = $this->getAttribute();
        if ( empty($attribute) ) {
            return [];
        }

        return [ $key => $attribute ];
    }

    /**
     * バリデーションルールの取得
     */
    public function getRules() : array|string|null {
        return null;
    }

    /**
     * バリデーションメッセージの取得
     */
    public function getMessages() : ?array {
        return null;
    }

    /**
     * バリデーション属性の取得
     */
    public function getAttribute() : string {
        return '値';
    }

    /**
     * 同じかどうかの判別を行う
     */
    public function equals( BaseObject $other ) : bool {
        return $this == $other;
    }

    /**
     * 値の取得
     *
     * @return string
     */
    public function value() {
        return $this->value;
    }

    /**
     * 文字列への変更を行う
     */
    public function __toString() : string {
        return (string)$this->value;
    }

    /**
     * データが空かどうかを判定する
     */
    public function isEmpty() : bool {
        if ( is_null($this->value) ) {
            return true;
        }

        if ( is_string($this->value) ) {
            return $this->value === '';
        }
        if ( is_array($this->value) ) {
            return count($this->value) === 0;
        }

        return $this->value === null;
    }
}
