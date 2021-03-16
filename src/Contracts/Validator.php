<?php

namespace Dive\Fez\Contracts;

interface Validator
{
    public function fails(string $value): bool;

    public function passes(string $value): bool;

    /**
     * @throws \Dive\Fez\Exceptions\ValidationException
     */
    public function validate(string $value): void;
}
