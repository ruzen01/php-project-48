<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    private function getFixtureContent($filename)
    {
        return file_get_contents(__DIR__ . "/fixtures/$filename");
    }

    public static function dataProvider(): array
    {
        return [
            ['expected_json.txt', 'file1.json', 'file2.json'],
            ['expected_yaml.txt', 'file1.yml', 'file2.yml'],
            ['expected_plain.txt', 'file1.json', 'file2.json', 'plain']
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProvider')]
    public function testGenDiff($expectedFile, $file1, $file2, $format = 'stylish')
    {
        $expected = $this->getFixtureContent($expectedFile);
        $actual = genDiff("tests/fixtures/$file1", "tests/fixtures/$file2", $format);
        $this->assertEquals($expected, $actual);
    }
}
