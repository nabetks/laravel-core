<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\BaseRule;
use Aijoh\Core\Support\Japanese;
use Closure;

class EncodeByteMax extends BaseRule
{
    public function __construct(private string $encodingTo, private int $max = 0)
    {
        if ($this->max <= 0) {
            throw new \Exception('maxは1以上である必要があります');
        }
    }

    protected function customRule(string $attribute, mixed $value, Closure $fail): void
    {
        $encodeTo = Japanese::encodeTo($value, $this->encodingTo);
        if (strlen($encodeTo) > $this->max) {
            $fail('aijoh-validation.encode_max_byte')->trnslate(
                [
                    'max' => $this->max,
                    'encode' => $this->encodingTo,
                ]
            );
        }
    }
}
