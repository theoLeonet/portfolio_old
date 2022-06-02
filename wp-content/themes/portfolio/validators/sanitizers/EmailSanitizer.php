<?php

namespace Portfolio\Validators\Sanitizers;

use Portfolio\Validators\Sanitizers\BaseSanitizer;

class EmailSanitizer extends BaseSanitizer
{
    public function getSanitizedValue()
    {
        return sanitize_email($this->value);
    }
}