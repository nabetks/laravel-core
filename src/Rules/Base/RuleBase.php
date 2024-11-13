<?php

namespace Aijoh\Core\Rules\Base;

use Aijoh\Core\Rules\Trait\InnerValidator;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Validation\Validator;

/**
 * Class RuleBase
 * @package Aijoh\Core\Rules\Base
 */
class RuleBase implements ValidationRule, ValidatorAwareRule {

    use InnerValidator;


    /**
     * バリデーションルールを設定する。
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     */
    public final function validate( string $attribute, mixed $value, Closure $fail ) : void {
        $innerRules = $this->getInnerRules();
        if( ! empty($innerRules) ){
            $results = $this->validation($attribute, $value, $fail, $innerRules, $this->getInnerMessages());
            if( ! $results ){
                return;
            }
        }
        $this->customRule($attribute, $value, $fail);
    }

    /**
     * バリデーションルールを設定する。
     * @return array
     */
    protected function getInnerRules() : array|string {
        return "";
    }

    /**
     * バリデーションメッセージを設定する。
     * @return array
     */
    protected function getInnerMessages() : array {
        return [];
    }


    /**
     * 独自ルールを設定する。
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     */
    protected function customRule(string $attribute, mixed $value, Closure $fail) : void {
    }
}
