<?php

namespace Dive\Fez\OpenGraph;

final class Profile extends RichObject
{
    public function firstName(string $firstName): self
    {
        return $this->setProperty('first_name', $firstName);
    }

    public function gender(string $gender): self
    {
        return $this->setProperty(__FUNCTION__, $gender);
    }

    public function lastName(string $lastName): self
    {
        return $this->setProperty('last_name', $lastName);
    }

    public function username(string $username): self
    {
        return $this->setProperty(__FUNCTION__, $username);
    }
}
