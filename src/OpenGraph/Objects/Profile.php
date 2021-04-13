<?php

namespace Dive\Fez\OpenGraph\Objects;

use Dive\Fez\OpenGraph\Property;
use Dive\Fez\OpenGraph\RichObject;

final class Profile extends RichObject
{
    public function firstName(string $firstName): self
    {
        return $this->setProperty(__FUNCTION__, Property::make('first_name', $firstName));
    }

    public function gender(string $gender): self
    {
        return $this->setProperty(__FUNCTION__, Property::make(__FUNCTION__, $gender));
    }

    public function lastName(string $lastName): self
    {
        return $this->setProperty(__FUNCTION__, Property::make('last_name', $lastName));
    }

    public function username(string $username): self
    {
        return $this->setProperty(__FUNCTION__, Property::make(__FUNCTION__, $username));
    }
}
