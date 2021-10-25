<?php declare(strict_types=1);

namespace Dive\Fez\Models\Casts;

use Closure;
use Dive\Fez\Exceptions\SorryUnexpectedComponent;
use Dive\Fez\TwitterCards\Cards\Player;
use Dive\Fez\TwitterCards\Cards\Summary;
use Dive\Fez\TwitterCards\Cards\SummaryLargeImage;
use Dive\Fez\TwitterCards\Property;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Arr;

class TwitterCardsCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        $tree = json_decode($value, true);

        if (is_null($tree)) {
            return $tree;
        }

        ['content' => $type] = Arr::pull($tree, 'card');

        return call_user_func(
            [$this->getCard($type), 'make'],
            array_map($this->propertyCaster(), $tree),
        );
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $value->toJson();
    }

    private function getCard(string $name): string
    {
        return match ($name) {
            'player' => Player::class,
            'summary' => Summary::class,
            'summary_large_image' => SummaryLargeImage::class,
            default => throw SorryUnexpectedComponent::make($name),
        };
    }

    private function propertyCaster(): Closure
    {
        return static function (array $prop) {
            return Property::make(Arr::get($prop, 'name'), Arr::get($prop, 'content'));
        };
    }
}
