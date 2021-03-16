<?php

namespace Dive\Fez\Validators;

use Dive\Fez\Concerns\Makeable;
use Dive\Fez\Contracts\Validator as Contract;
use Dive\Fez\Exceptions\ValidationException;

abstract class Validator implements Contract
{
    use Makeable;

    protected array $data;

    final public function __construct()
    {
        $this->data = $this->dataProvider();
    }

    abstract protected function dataProvider(): array;

    public function fails(string $property, string|array $value): bool
    {
        return ! $this->passes($property, $value);
    }

    public function validate(string $property, array|string $value): void
    {
        if ($this->fails($property, $value)) {
            throw ValidationException::make($property, $value);
        }
    }
}
