<?php

namespace Aijoh\Core\ValueObjects;


use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BaseObject {


    private static string $validateKey = "value";

    public function __construct( protected mixed $value, bool $isValidate = true ) {
        if ( $isValidate ) {
            $this->value = $this->validate($this->value);
        }
    }

    /**
     * バリデーションせずにインスタンスを生成する
     * @param mixed $value
     * @return static
     */
    public static function makeForce( mixed $value ) : static {
        return new static($value, false);
    }

    /**
     * 入力値のチェックを行う。
     * @param mixed $value 入力値
     * @return mixed チェック後の値
     * @throws ValidationException バリデーション例外
     */
    protected function validate( mixed $value ) : mixed {
        $value = $this->beforeValidate($value);

        $rules = $this->getValidationRules(static::$validateKey);
        if ( empty($rules) ) {
            return $value;
        }
        $attributes = $this->getValidationAttribute(static::$validateKey);
        $messages = $this->getValidationMessages(static::$validateKey);

        $results = Validator::make([ static::$validateKey => $value ], $rules, $messages, $attributes)->validate();
        $value = $results[ static::$validateKey ];

        return $this->afterValidate($value);
    }


    /**
     * バリデーション前の処理
     * @param mixed $value バリデーション前の処理
     * @return mixed
     */
    protected function beforeValidate( $value ) {
        return $this->value;
    }

    /**
     * バリデーション後の処理
     * @param mixed $value
     * @return mixed
     */
    protected function afterValidate( $value ) {
        return $value;
    }


    /**
     * バリデーション属性の取得
     * @param string $key キー
     * @param array $beforeRules 前のルール
     * @param array $afterRules 後のルール
     * @return array|string|null
     */
    public final function getValidationRules( string $key, array $beforeRules = [], array $afterRules = [] ) : array|string|null {
        $rules = $this->getRules();
        if( is_string($rules) ){
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
     * @param string $key キー値
     * @param array $addMessages 追加のメッセージ
     * @return array
     */
    public final function getValidationMessages( string $key, array $addMessages = [] ) : array {
        $messages = array_merge( $this->getMessages() , $addMessages );
        if ( empty($messages) ) {
            return [];
        }

        $results = [];
        foreach ( $messages as $key => $message ) {
            $results[ $key . '.' . $key ] = $message;
        }
        return $results;
    }


    public final function getValidationAttribute( string $key ) : array {
        $attribute = $this->getAttribute();
        if ( empty($attribute) ) {
            return [];
        }
        return [ $key => $attribute ];
    }

    /**
     * バリデーションルールの取得
     * @return array|string|null
     */
    public function getRules() : array|string|null {
        return null;
    }

    /**
     * バリデーションメッセージの取得
     * @return array|null
     */
    public function getMessages() : array|null {
        return null;
    }

    /**
     * バリデーション属性の取得
     * @return string
     */
    public function getAttribute() : string {
        return "値";
    }


    /**
     * 同じかどうかの判別を行う
     * @param BaseObject $other
     * @return bool
     */
    public function eqauls( BaseObject $other ) : bool {
        return $this == $other;
    }


    /**
     * 値の取得
     * @return string
     */
    public function value() {
        return $this->value;
    }

    /**
     * 文字列への変更を行う
     * @return string
     */
    public function __toString() : string {
        return (string)$this->value;
    }

}
