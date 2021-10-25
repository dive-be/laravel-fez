<?php declare(strict_types=1);

namespace Dive\Fez\Contracts;

interface Generable
{
    public function generate(): string;
}
