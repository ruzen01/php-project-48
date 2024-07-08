<?php

namespace Differ\Formatters\Stylish;

function format(array $diff): string
{
    return "{\n" . formatDiff($diff) . "\n}";
}

function formatDiff(array $diff, int $depth = 0): string
{
    $indent = str_repeat('    ', $depth);
    $lines = array_map(function ($node) use ($indent, $depth) {
        $key = $node['key'];
        switch ($node['type']) {
            case 'nested':
                $value = "{\n" . formatDiff($node['children'], $depth + 1) . "\n$indent    }";
                return "$indent    $key: $value";
            case 'added':
                $value = stringify($node['value'], $depth + 1);
                return "$indent  + $key: $value";
            case 'removed':
                $value = stringify($node['value'], $depth + 1);
                return "$indent  - $key: $value";
            case 'changed':
                $oldValue = stringify($node['oldValue'], $depth + 1);
                $newValue = stringify($node['newValue'], $depth + 1);
                return "$indent  - $key: $oldValue\n$indent  + $key: $newValue";
            case 'unchanged':
                $value = stringify($node['value'], $depth + 1);
                return "$indent    $key: $value";
        }
    }, $diff);

    return implode("\n", $lines);
}

function stringify(mixed $value, int $depth): string
{
    $result = '';

    if (is_array($value)) {
        $indent = str_repeat('    ', $depth);
        $lines = array_map(function ($key, $val) use ($depth, $indent) {
            $formattedVal = stringify($val, $depth + 1);
            return "$indent    $key: $formattedVal";
        }, array_keys($value), $value);
        $result = "{\n" . implode("\n", $lines) . "\n$indent}";
    } elseif (is_bool($value)) {
        $result = $value ? 'true' : 'false';
    } elseif (is_null($value)) {
        $result = 'null';
    } else {
        $result = (string)$value;
    }

    return $result;
}
