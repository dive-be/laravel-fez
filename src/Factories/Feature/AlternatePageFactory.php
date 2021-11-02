<?php declare(strict_types=1);

namespace Dive\Fez\Factories\Feature;

use Dive\Fez\AlternatePage;
use Dive\Fez\Support\Makeable;
use Illuminate\Http\Request;

class AlternatePageFactory
{
    use Makeable;

    public function __construct(
        private Request $request,
    ) {}

    public function create(array $locales): AlternatePage
    {
        return AlternatePage::make($locales, $this->request);
    }
}
