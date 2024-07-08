<?php

namespace Differ\Parsers;

use Exception;

function parse(string $content, string $extension): array
{
    switch ($extension) {
        case 'json':
            return json_decode($content, true);
        case 'yml':
        case 'yaml':
            if (!extension_loaded('yaml')) {
                throw new Exception("YAML extension is not loaded.");
            }
            return yaml_parse($content);
        default:
            throw new Exception("Unsupported file format: {$extension}");
    }
}

function getFileContent(string $path): string
{
    if (!file_exists($path)) {
        throw new Exception("File not found: {$path}");
    }

    $content = file_get_contents($path);
    if ($content === false) {
        throw new Exception("Could not read file: {$path}");
    }

    return $content;
}