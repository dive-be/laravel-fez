<?php

namespace Dive\Fez\Contracts;

interface Validator
{
    public function fails(string $property, array|string $value): bool;

    public function passes(string $property, array|string $value): bool;

    /**
     * @throws \Dive\Fez\Exceptions\ValidationException
     */
    public function validate(string $property, array|string $value): void;
}
