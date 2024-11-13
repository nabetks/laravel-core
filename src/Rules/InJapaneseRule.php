<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\RuleBase;
use Aijoh\Core\Support\Japanese;
use Illuminate\Contracts\Validation\ValidationRule;

class InJapaneseRule extends RuleBase {

    protected function customRule( string $attribute, mixed $value, \Closure $fail ) : void {
        if (Japanese::inJapanese($value)) {
            $fail('aijoh-validation.in_japanese')->translate();
        }
    }
}
