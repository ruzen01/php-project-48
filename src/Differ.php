<?php

namespace Differ\Differ;

use function Functional\sort;

function genDiff($pathToFile1, $pathToFile2)
{
    $data1 = parseFile($pathToFile1);
    $data2 = parseFile($pathToFile2);

    $keys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    $keys = sort($keys, fn($a, $b) => strcmp($a, $b));

    $diff = array_reduce($keys, function ($acc, $key) use ($data1, $data2) {
        if (!array_key_exists($key, $data1)) {
            $acc[] = "  + {$key}: " . json_encode($data2[$key]);
        } elseif (!array_key_exists($key, $data2)) {
            $acc[] = "  - {$key}: " . json_encode($data1[$key]);
        } elseif ($data1[$key] !== $data2[$key]) {
            $acc[] = "  - {$key}: " . json_encode($data1[$key]);
            $acc[] = "  + {$key}: " . json_encode($data2[$key]);
        } else {
            $acc[] = "    {$key}: " . json_encode($data1[$key]);
        }
        return $acc;
    }, []);

    return "{\n" . implode("\n", $diff) . "\n}";
}

function parseFile($path)
{
    $absolutePath = realpath($path);
    if ($absolutePath === false) {
        throw new \Exception("File not found: {$path}");
    }
    $content = file_get_contents($absolutePath);
    return json_decode($content, true);
}
