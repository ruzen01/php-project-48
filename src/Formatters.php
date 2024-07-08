<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\format as formatStylish;
use function Differ\Formatters\Plain\format as formatPlain;
use function Differ\Formatters\Json\format as formatJson;

function format(array $diff, string $format): string
{
    switch ($format) {
        case 'plain':
            return formatPlain($diff);
        case 'json':
            return formatJson($diff);
        case 'stylish':
        default:
            return formatStylish($diff);
    }
}
