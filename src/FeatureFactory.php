<?php declare(strict_types=1);

namespace Dive\Fez;

use Closure;
use Dive\Fez\Contracts\Formatter;
use Dive\Fez\Exceptions\SorryUnexpectedComponent;
use Dive\Fez\Formatters\DefaultFormatter;
use Dive\Fez\Formatters\NullFormatter;
use Dive\Fez\Support\Makeable;

class FeatureFactory
{
    use Makeable;

    private Formatter $formatter;

    private Closure $requestResolver;

    private Closure $urlResolver;

    public function __construct(private array $config) {}

    public function create(string $feature): Component
    {
        return match ($feature) {
            Feature::alternatePage() => $this->alternatePage(),
            Feature::metaElements() => $this->metaElements(),
            default => throw SorryUnexpectedComponent::make($feature),
        };
    }

    private function alternatePage(): AlternatePage
    {
        return AlternatePage::make($this->config['locales'], call_user_func($this->requestResolver));
    }

    private function metaElements(): MetaElements
    {
        return MetaElements::make(call_user_func($this->urlResolver), $this->formatter());
    }

    private function formatter(): Formatter
    {
        if (isset($this->formatter)) {
            return $this->formatter;
        }

        $config = $this->config['title'];

        if (is_string($config) && class_exists($config)) {
            return $this->formatter = new $config();
        }

        if (is_array($config)) {
            return $this->formatter = DefaultFormatter::make($config['suffix'], $config['separator']);
        }

        return $this->formatter = NullFormatter::make();
    }

    public function setRequestResolver(Closure $callback): self
    {
        $this->requestResolver = $callback;

        return $this;
    }

    public function setUrlResolver(Closure $callback): self
    {
        $this->urlResolver = $callback;

        return $this;
    }
}
