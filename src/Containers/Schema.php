<?php

namespace Dive\Fez\Containers;

final class Schema extends Container
{
    public function generate(): string
    {
        return '<script type="application/ld+json">'
            .$this->toJson(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            .'</script>';
    }

    public function toArray(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'email' => 'info@dive.be',
            'name' => 'DIVE',
            'url' => 'https://dive.be',
            'vatID' => 'BE0682.803.091',
        ];
    }
}
