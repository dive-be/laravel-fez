<?php

namespace Dive\Fez\Models;

use Spatie\Translatable\HasTranslations;

class TranslatableMeta extends Meta
{
    use HasTranslations;

    protected array $translatable = ['description', 'title'];
}
