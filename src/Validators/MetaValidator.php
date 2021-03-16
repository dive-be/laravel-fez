<?php

namespace Dive\Fez\Validators;

use Illuminate\Support\Arr;

class MetaValidator extends Validator
{
    public function passes(string $property, array|string $value): bool
    {
        if (! Arr::has($this->data, $property)) {
            return false;
        }

        if (! is_array($possibilities = Arr::get($this->data, $property))) {
            return true;
        }

        $value = Arr::wrap($value);

        return count(array_intersect($possibilities, $value)) === count($value);
    }

    protected function dataProvider(): array
    {
        return require_once __DIR__.'/../../resources/data/meta.php';
    }
}
