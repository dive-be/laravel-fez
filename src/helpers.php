<?php declare(strict_types=1);

use Dive\Fez\Feature;

if (! function_exists('alternate')) {
    function alternate()
    {
        return fez(Feature::alternatePage());
    }
}

if (! function_exists('fez')) {
    function fez(array|string|null $key = null)
    {
        if (is_null($key)) {
            return app('fez');
        }

        if (is_array($key)) {
            return app('fez')->set($key);
        }

        return app('fez')->get($key);
    }
}

if (! function_exists('meta')) {
    function meta(?string $key = null)
    {
        if (is_null($key)) {
            return fez(Feature::metaElements());
        }

        return fez(Feature::metaElements())->get($key);
    }
}

if (! function_exists('og')) {
    function og(?string $key = null)
    {
        if (is_null($key)) {
            return fez(Feature::openGraph());
        }

        return fez(Feature::openGraph())->get($key);
    }
}

if (! function_exists('twitter')) {
    function twitter(?string $key = null) {
        if (is_null($key)) {
            return fez(Feature::twitterCards());
        }

        return fez(Feature::twitterCards())->get($key);
    }
}
