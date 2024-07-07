<?php

namespace Differ\Differ;

use Differ\Parsers;

function genDiff(string $pathToFile1, string $pathToFile2): string
{
    $absolutePath1 = realpath($pathToFile1);
    $absolutePath2 = realpath($pathToFile2);

    if (!$absolutePath1 || !$absolutePath2) {
        throw new \Exception("File not found");
    }

    $data1 = Parsers\parse($absolutePath1);
    $data2 = Parsers\parse($absolutePath2);

    $allKeys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    sort($allKeys);

    $diff = [];
    foreach ($allKeys as $key) {
        if (!array_key_exists($key, $data1)) {
            $diff[] = "  + {$key}: " . json_encode($data2[$key]);
        } elseif (!array_key_exists($key, $data2)) {
            $diff[] = "  - {$key}: " . json_encode($data1[$key]);
        } elseif ($data1[$key] !== $data2[$key]) {
            $diff[] = "  - {$key}: " . json_encode($data1[$key]);
            $diff[] = "  + {$key}: " . json_encode($data2[$key]);
        } else {
            $diff[] = "    {$key}: " . json_encode($data1[$key]);
        }
    }

    return "{\n" . implode("\n", $diff) . "\n}";
}