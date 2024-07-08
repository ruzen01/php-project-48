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

function stringify($value, int $depth): string
{
    if (is_null($value)) {
        return 'null';
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_string($value)) {
        return $value;
    }
    if (is_array($value)) {
        $indent = str_repeat('    ', $depth);
        $lines = array_map(function ($key, $val) use ($indent, $depth) {
            $formattedValue = stringify($val, $depth + 1);
            return "$indent    $key: $formattedValue";
        }, array_keys($value), $value);
        return "{\n" . implode("\n", $lines) . "\n$indent}";
    }
    return (string) $value;
}
