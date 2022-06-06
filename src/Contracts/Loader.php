<?php declare(strict_types=1);

namespace Dive\Fez\Contracts;

use Dive\Fez\Manager;
use Dive\Fez\MetaData;

interface Loader
{
    public function load(Manager $fez, MetaData $data);
}
