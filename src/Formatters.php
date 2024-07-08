<?php

namespace Differ\Formatters;

use Differ\Formatters\Stylish;

function format(array $diff, string $format = 'stylish'): string
{
    switch ($format) {
        case 'stylish':
            return Stylish\format($diff);
        // Здесь можно добавить другие форматтеры
        default:
            throw new \Exception("Unsupported format: {$format}");
    }
}
