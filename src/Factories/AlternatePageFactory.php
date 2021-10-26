<?php declare(strict_types=1);

namespace Dive\Fez\Factories;

use Dive\Fez\AlternatePage;
use Dive\Fez\Support\Makeable;
use Illuminate\Http\Request;

class AlternatePageFactory
{
    use Makeable;

    public function __construct(private array $locales, private Request $request) {}

    public function create(): AlternatePage
    {
        return AlternatePage::make($this->locales, $this->request);
    }
}
