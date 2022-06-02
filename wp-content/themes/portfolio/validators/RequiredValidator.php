<?php

namespace Portfolio\Validators;

class RequiredValidator extends BaseValidator
{
    protected function handle($value): ?string
    {
        if (is_null($value) || $value === '' || (is_array($value) && empty($value))) {
            return 'This field can’t be empty.';
        }

        return null;
    }
}