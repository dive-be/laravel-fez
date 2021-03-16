<?php

namespace Dive\Fez\Validators;

use Dive\Fez\Concerns\Makeable;
use Dive\Fez\Contracts\Validator as Contract;
use Dive\Fez\Exceptions\ValidationException;
use Illuminate\Support\Str;

abstract class Validator implements Contract
{
    use Makeable;

    protected array $data;

    final public function __construct()
    {
        $this->data = $this->dataProvider();
    }

    abstract protected function dataProvider(): array;

    public function fails(string $value): bool
    {
        return ! $this->passes($value);
    }

    public function validate(string $value): void
    {
        if ($this->fails($value)) {
            throw ValidationException::make(Str::before(class_basename(static::class), 'Validator'), $value);
        }
    }
}
