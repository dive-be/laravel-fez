<?php

namespace Dive\Fez\Models;

use Spatie\Translatable\HasTranslations;

class TranslatableMetaData extends MetaData
{
    use HasTranslations;

    protected $table = 'meta_data';

    protected array $translatable = ['description', 'image', 'title'];
}
