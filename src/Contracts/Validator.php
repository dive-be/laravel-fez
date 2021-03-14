<?php

namespace Dive\Fez\Contracts;

interface Validator
{
    public function fails(string $value): bool;

    public function validate(string $value): bool;
}
