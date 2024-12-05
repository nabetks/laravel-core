<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Exception\EncodingException;
use Aijoh\Core\Rules\Base\BaseRule;
use Aijoh\Core\Support\Japanese;
use Closure;

class EncodeByteMaxRule extends BaseRule {
    public function __construct( private readonly string $encodingTo, private int $max ) {
        if ( $this->max <= 0 ) {
            throw new \Exception('maxは1以上である必要があります');
        }
    }

    protected function customRule( string $attribute, mixed $value, Closure $fail ) : void {
        try {
            $byte = Japanese::getEncodeByte($value, $this->encodingTo);
            if ( $byte > $this->max ) {
                $fail("aijoh-validation.encode_byte_max")->translate(
                    [
                        'max'      => $this->max,
                        'encoding' => $this->encodingTo,
                    ]
                );
                return;
            }

        } catch ( EncodingException $ex ) {
            $fail("aijoh-validation.encode_to")->translate(
                [
                    'encoding' => $this->encodingTo,
                ]
            );
            return;
        }
    }
}
