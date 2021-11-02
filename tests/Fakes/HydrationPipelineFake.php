<?php declare(strict_types=1);

namespace Tests\Fakes;

use Dive\Fez\Hydration\HydrationPipeline;
use PHPUnit\Framework\Assert;

class HydrationPipelineFake extends HydrationPipeline
{
    private bool $hasRun = false;

    public function reset()
    {
        $this->hasRun = false;
    }

    public function thenReturn()
    {
        $this->hasRun = true;
    }

    public function assertRanEntirely()
    {
        Assert::assertTrue($this->hasRun, $msg = 'Failed asserting that the pipeline has run.');
        Assert::assertEquals((new static())->pipes(), $this->pipes, $msg);
    }

    public function assertRanPartially(array $properties)
    {
        Assert::assertTrue($this->hasRun, $msg = 'Failed asserting that the given pipes have run.');
        Assert::assertEquals(array_intersect_key(static::$mapping, array_flip($properties)), $this->pipes, $msg);
    }
}
