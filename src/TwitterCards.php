<?php

namespace Dive\Fez;

use Dive\Fez\Contracts\Hydratable;
use Dive\Fez\Contracts\Imageable;
use Dive\Fez\Models\MetaData;
use Dive\Fez\TwitterCards\Cards\Player;
use Dive\Fez\TwitterCards\Cards\Summary;
use Dive\Fez\TwitterCards\Cards\SummaryLargeImage;

final class TwitterCards extends Container implements Hydratable, Imageable
{
    public function __construct(private TitleFormatter $formatter, array $defaults)
    {
        parent::__construct($defaults);
    }

    public static function player(): Player
    {
        return Player::make();
    }

    public static function summary(): Summary
    {
        return Summary::make();
    }

    public static function summaryLargeImage(): SummaryLargeImage
    {
        return SummaryLargeImage::make();
    }

    public function generate(): string
    {
        return $this
            ->toCollection()
            ->map(fn ($content, $prop) => $prop === 'title' ? $this->formatter->format($content) : $content)
            ->map(fn ($content, $name) => '<meta name="'.self::PREFIX.':'.$name.'" content="'.$content.'" />')
            ->join(PHP_EOL);
    }

    public function hydrate(MetaData $data): void
    {
        $this->properties = array_merge(
            $this->properties,
            array_merge(array_filter($data->only('description', 'image', 'title')), $data->twitter ?? []),
        );
    }
}
