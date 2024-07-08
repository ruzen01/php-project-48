<?php

namespace Differ\Formatters\Plain;

function format(array $diff): string
{
    $lines = array_map(function ($node) {
        return formatNode($node);
    }, $diff);

    return implode("\n", array_filter($lines));
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
            return implode("\n", array_map(
                fn($child) => formatNode($child, $currentPath),
                $node['children']
            ));
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
    return is_string($value) ? "'{$value}'" : (string)$value;
}