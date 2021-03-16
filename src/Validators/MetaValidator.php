<?php

namespace Dive\Fez\Validators;

class MetaValidator extends Validator
{
    public function passes(string $value): bool
    {
        return in_array($value, $this->data);
    }

    protected function dataProvider(): array
    {
        return require_once __DIR__.'../../resources/data/meta.php';
    }
}
