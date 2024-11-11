<?php

namespace Aijoh\Core\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class Furigana implements ValidationRule
{
    public function __construct() {}

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $separate = Str::of($value)->splitBlank()->normalize()->toHiragana();
        if ($separate->count() !== 2) {
            $fail('フリガナは姓と名の間にスペースを入れてください。');
        }

        foreach ($separate as $part) {
            if (! Str::isHiragana($part)) {
                $fail('フリガナを正しく入力してください。');
            }
        }
    }
}
