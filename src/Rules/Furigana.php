<?php

namespace Aijoh\Core\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class Furigana implements ValidationRule{

    public function __construct()
    {
        //
    }


    public function validate( string $attribute, mixed $value, Closure $fail ) : void {
        $name = Str::splitBlak($value);
    }
}
