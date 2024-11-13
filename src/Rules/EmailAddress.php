<?php

namespace Aijoh\Core\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Validator;

class EmailAddress implements ValidationRule {

    public function validate( string $attribute, mixed $value, Closure $fail ) : void {
        $validator = \Illuminate\Support\Facades\Validator::make(
            [$attribute => $value],
            [$attribute => 'string|max:255|email'],
        );

        if( $validator->fails() ) {
            $fail($validator->errors()->first());
        }
    }
}
