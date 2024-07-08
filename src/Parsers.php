<?php

namespace Differ\Parsers;

use Exception;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

function parse(string $content, string $extension): array
{
    switch ($extension) {
        case 'json':
            $result = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Invalid JSON: " . json_last_error_msg());
            }
            return $result;
        case 'yml':
        case 'yaml':
            try {
                return Yaml::parse($content);
            } catch (ParseException $e) {
                throw new Exception("YAML parsing error: " . $e->getMessage());
            }
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
