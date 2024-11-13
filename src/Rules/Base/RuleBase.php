<?php

namespace Aijoh\Core\Rules\Base;

use Aijoh\Core\Rules\Trait\InnerValidator;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;

/**
 * Class RuleBase
 */
class RuleBase implements ValidationRule, ValidatorAwareRule
{
    use InnerValidator;

    /**
     * 空文字列の場合にバリデーションを行うかどうか。
     */
    public bool $implicit = false;

    /**
     * バリデーションルールを設定する。
     */
    final public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $innerRules = $this->getInnerRules();
        if (! empty($innerRules)) {
            if (! $this->validation($attribute, $value, $fail, $innerRules, $this->getInnerMessages())) {
                return;
            }
        }
        $this->customRule($attribute, $value, $fail);
    }

    /**
     * バリデーションルールを設定する。
     *
     * @return array
     */
    protected function getInnerRules(): array|string
    {
        return '';
    }

    /**
     * バリデーションメッセージを設定する。
     */
    protected function getInnerMessages(): array
    {
        return [];
    }

    /**
     * 独自ルールを設定する。
     */
    protected function customRule(string $attribute, mixed $value, Closure $fail): void {}
}
