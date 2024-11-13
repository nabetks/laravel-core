<?php

namespace Aijoh\Core\Rules\Trait;

use Illuminate\Validation\Validator;

trait InnerValidator
{
    private Validator $validator;

    protected array $rules = [];

    protected array $messages = [];

    /**
     * 表示用の属性名を取得
     */
    protected function getDisplayAttribute($attribute): string
    {
        $displayAttribute = $this->validator->getDisplayableAttribute($attribute);

        return $displayAttribute === $attribute ? ucfirst($attribute) : $displayAttribute;
    }

    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * 内部で使用するバリデーションメソッド
     *
     * @return void
     */
    protected function validation(string $attribute, mixed $value, \Closure $fail, array|string $rules, array $messages = []): bool
    {
        $validator = \Illuminate\Support\Facades\Validator::make(
            [$attribute => $value],
            [$attribute => $rules],
            $messages,
            [$attribute => $this->getDisplayAttribute($attribute)]
        );

        if ($validator->fails()) {
            $fail($validator->errors()->first());

            return false;
        }

        return true;
    }
}
