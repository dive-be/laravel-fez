<?php

namespace Dive\Fez\Validators;

use Dive\Fez\Contracts\Validator;

abstract class ContainerValidator implements Validator
{
    public function fails(string $value): bool
    {
        return ! $this->validate($value);
    }

    abstract public function validate(string $value): bool;
}
