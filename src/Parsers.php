<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $filepath): array
{
    $content = file_get_contents($filepath);
    $extension = pathinfo($filepath, PATHINFO_EXTENSION);

    switch ($extension) {
        case 'json':
            return json_decode($content, true);
        case 'yml':
        case 'yaml':
            $parsedContent = Yaml::parse($content);
            return json_decode(json_encode($parsedContent), true); // Преобразуем объект в массив
        default:
            throw new \Exception("Unsupported file format: $extension");
    }
}
