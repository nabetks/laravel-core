<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Support\Japanese;
use Illuminate\Contracts\Validation\ValidationRule;

class Hiragana implements ValidationRule {


    public function validate( string $attribute, mixed $value, \Closure $fail ) : void {
        if( ! Japanese::isHiragana($value) ) {
            $fail('aijoh-validation.hiragana')->translate();
        }
    }

}
