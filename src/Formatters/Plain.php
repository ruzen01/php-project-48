<?php

namespace Differ\Formatters\Plain;

function format(array $diff): string
{
    $lines = array_map(function ($node) {
        return formatNode($node);
    }, $diff);

    $filteredLines = array_filter($lines, fn($line) => $line !== null && $line !== '');
    return implode("\n", $filteredLines);
}

function formatNode(array $node, string $path = ''): ?string
{
    $currentPath = $path !== '' ? "{$path}.{$node['key']}" : $node['key'];

    switch ($node['type']) {
        case 'added':
            return "Property '{$currentPath}' was added with value: " . formatValue($node['value']);
        case 'removed':
            return "Property '{$currentPath}' was removed";
        case 'changed':
            return "Property '{$currentPath}' was updated. From " . formatValue($node['oldValue']) . " to " . formatValue($node['newValue']);
        case 'nested':
            return implode("\n", array_filter(array_map(
                fn($child) => formatNode($child, $currentPath),
                $node['children']
            )));
        case 'unchanged':
            return null;
        default:
            return null;
    }
}

function formatValue(mixed $value): string
{
    if (is_array($value)) {
        return '[complex value]';
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
        return 'null';
    }
    if (is_string($value)) {
        return "'{$value}'";
    }
    return (string)$value;
}
