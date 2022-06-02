<?php

namespace Portfolio\Validators;

class EmailValidator extends BaseValidator
{
    protected function handle($value): ?string
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return 'Invalid email address';
        }

        return null;
    }
}