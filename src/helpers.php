<?php

use Dive\Fez\Component;
use Dive\Fez\Fez;

if (! function_exists('fez')) {
    function fez(?string $component = null)
    {
        if (is_null($component)) {
            return app(__FUNCTION__);
        }

        return app(__FUNCTION__)->get($component);
    }
}
