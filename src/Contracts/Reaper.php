<?php

namespace Dive\Fez\Contracts;

interface Reaper
{
    public function seek(\Illuminate\Routing\Route $route): ?Metable;
}
