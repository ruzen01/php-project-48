<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\format as formatStylish;
use function Differ\Formatters\Plain\format as formatPlain;

function format(array $diff, string $format): string
{
    switch ($format) {
        case 'plain':
            return formatPlain($diff);
        case 'stylish':
        default:
            return formatStylish($diff);
    }
}