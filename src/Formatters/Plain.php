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
    $currentPath = $path ? "{$path}.{$node['key']}" : $node['key'];

    return match ($node['type']) {
        'added' => "Property '{$currentPath}' was added with value: " . formatValue($node['value']),
        'removed' => "Property '{$currentPath}' was removed",
        'changed' => "Property '{$currentPath}' was updated. From " . formatValue($node['oldValue']) . " to " . formatValue($node['newValue']),
        'nested' => implode("\n", array_filter(array_map(
            fn($child) => formatNode($child, $currentPath),
            $node['children']
        ))),
        'unchanged' => null,
        default => null,
    };
}

function formatValue(mixed $value): string
{
    return match (true) {
        is_array($value) => '[complex value]',
        is_bool($value) => $value ? 'true' : 'false',
        is_null($value) => 'null',
        is_string($value) => "'{$value}'",
        default => (string)$value,
    };
}
