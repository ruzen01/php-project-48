<?php

namespace Differ\Differ;

use Differ\Parsers;
use Differ\Formatters;

function genDiff(string $pathToFile1, string $pathToFile2, string $format = 'stylish'): string
{
    $data1 = parseFile($pathToFile1);
    $data2 = parseFile($pathToFile2);

    $diff = buildDiff($data1, $data2);

    return Formatters\format($diff, $format);
}

function parseFile(string $filePath): array
{
    $content = Parsers\getFileContent($filePath);
    return Parsers\parse($content, pathinfo($filePath, PATHINFO_EXTENSION));
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
    sort($keys);
    return $keys;
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
