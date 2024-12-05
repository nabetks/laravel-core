<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Exception\EncodingException;
use Aijoh\Core\Rules\Base\BaseRule;
use Aijoh\Core\Support\Japanese;
use Closure;

class EncodeByteBetweenRule extends BaseRule
{
    public function __construct(private readonly string $encodingTo, private int $min, private int $max)
    {
        if ($this->min <= 0) {
            throw new \Exception('minは0以上である必要があります');
        }

        if ($this->max <= 0) {
            throw new \Exception('maxは1以上である必要があります');
        }

        if ($this->min > $this->max) {
            throw new \Exception('minはmaxより小さい値である必要があります');
        }

    }

    protected function customRule(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $byte = Japanese::getEncodeByte($value, $this->encodingTo);
            if ($byte < $this->min || $byte > $this->max) {
                $fail('aijoh-validation.encode_byte_max')->translate(
                    [
                        'min' => $this->min,
                        'max' => $this->max,
                        'encoding' => $this->encodingTo,
                    ]
                );

                return;
            }

        } catch (EncodingException $ex) {
            $fail('aijoh-validation.encode_to')->translate(
                [
                    'encoding' => $this->encodingTo,
                ]
            );

            return;
        }
    }
}
