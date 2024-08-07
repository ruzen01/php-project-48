<?php

namespace Differ\Differ;

use Differ\Parsers;
use Differ\Formatters;

function genDiff(string $pathToFile1, string $pathToFile2, string $format = 'stylish'): string
{
    $data1 = Parsers\parseFile($pathToFile1);
    $data2 = Parsers\parseFile($pathToFile2);

    $diff = buildDiff($data1, $data2);

    return Formatters\format($diff, $format);
}

function buildDiff(array $data1, array $data2): array
{
    $keys = getUniqueSortedKeys($data1, $data2);

    return array_map(function ($key) use ($data1, $data2) {
        return getNode($key, $data1, $data2);
    }, $keys);
}

function getUniqueSortedKeys(array $data1, array $data2): array
{
    $keys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    return array_values(array_reduce($keys, function ($acc, $key) {
        $insertIndex = array_reduce(array_keys($acc), function ($carry, $index) use ($acc, $key) {
            return (strcmp($acc[$index], $key) < 0) ? $index + 1 : $carry;
        }, 0);
        return array_merge(
            array_slice($acc, 0, $insertIndex),
            [$key],
            array_slice($acc, $insertIndex)
        );
    }, []));
}

function getNode(string $key, array $data1, array $data2): array
{
    if (!array_key_exists($key, $data1)) {
        return ['key' => $key, 'type' => 'added', 'value' => $data2[$key]];
    }
    if (!array_key_exists($key, $data2)) {
        return ['key' => $key, 'type' => 'removed', 'value' => $data1[$key]];
    }
    if (is_array($data1[$key]) && is_array($data2[$key])) {
        return ['key' => $key, 'type' => 'nested', 'children' => buildDiff($data1[$key], $data2[$key])];
    }
    if ($data1[$key] !== $data2[$key]) {
        return [
            'key' => $key,
            'type' => 'changed',
            'oldValue' => $data1[$key],
            'newValue' => $data2[$key]
        ];
    }
    return ['key' => $key, 'type' => 'unchanged', 'value' => $data1[$key]];
}
