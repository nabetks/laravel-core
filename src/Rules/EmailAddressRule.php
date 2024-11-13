<?php

namespace Aijoh\Core\Rules;

use Aijoh\Core\Rules\Base\RuleBase;
use Aijoh\Core\Rules\Trait\InnerValidator;
use Illuminate\Validation\Validator as Validation;

class EmailAddressRule extends RuleBase
{
    use InnerValidator;

    private Validation $validator;

    protected function getInnerRules(): array|string
    {
        return 'string|max:255|email';
    }
}
