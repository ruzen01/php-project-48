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

    switch ($node['type']) {
        case 'added':
            $val = formatValue($node['value']);
            return "Property '{$currentPath}' was added with value: {$val}";
        case 'removed':
            return "Property '{$currentPath}' was removed";
        case 'changed':
            $oldVal = formatValue($node['oldValue']);
            $newVal = formatValue($node['newValue']);
            return "Property '{$currentPath}' was updated. From {$oldVal} to {$newVal}";
        case 'nested':
            $nestedLines = array_map(
                fn($child) => formatNode($child, $currentPath),
                $node['children']
            );
            return implode("\n", array_filter($nestedLines));
        case 'unchanged':
            return null;
    }
    return null;
}

function formatValue($value): string
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