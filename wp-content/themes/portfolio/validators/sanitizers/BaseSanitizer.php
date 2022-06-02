<?php

namespace Portfolio\Validators\Sanitizers;

abstract class BaseSanitizer
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    abstract public function getSanitizedValue();
}