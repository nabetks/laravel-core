<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\BaseRule;
use Aijoh\Core\Rules\Trait\InnerValidator;
use Illuminate\Validation\Validator as Validation;

class EmailAddressRule extends BaseRule
{
    use InnerValidator;

    private Validation $validator;

    protected function getInnerRules(): array|string
    {
        return 'string|max:255|email';
    }
}
