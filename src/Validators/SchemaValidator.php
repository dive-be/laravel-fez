<?php

namespace Dive\Fez\Validators;

class SchemaValidator extends Validator
{
    public function passes(string $value): bool
    {
        return true;
    }

    protected function dataProvider(): array
    {
        return require_once __DIR__.'../../resources/data/schema.php';
    }
}
