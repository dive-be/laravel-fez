<?php declare(strict_types=1);

namespace Dive\Fez;

class Directive
{
    public static function compile(string $expression = ''): string
    {
        $expression = trim($expression);

        return '<?php echo e(fez()' . (empty($expression) ? '' : "->only({$expression})") . ') . PHP_EOL ?>';
    }
}
