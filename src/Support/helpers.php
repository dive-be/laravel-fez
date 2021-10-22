<?php

if (! function_exists('fez')) {
    function fez(array|string|null $component = null)
    {
        if (is_null($component)) {
            return app(__FUNCTION__);
        }

        if (is_array($component)) {
            return app(__FUNCTION__)->set($component);
        }

        return app(__FUNCTION__)->get($component);
    }
}
