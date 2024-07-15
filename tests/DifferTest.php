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
            ['expected_default.txt', 'file1.json', 'file2.json'],
            ['expected_default.txt', 'file1.yml', 'file2.yml']
        ];
    }

    public static function dataProviderStylish(): array
    {
        return [
            ['expected_stylish.txt', 'file1.json', 'file2.json'],
            ['expected_stylish.txt', 'file1.yml', 'file2.yml']
        ];
    }

    public static function dataProviderPlain(): array
    {
        return [
            ['expected_plain.txt', 'file1.json', 'file2.json'],
            ['expected_plain.txt', 'file1.yml', 'file2.yml']
        ];
    }

    public static function dataProviderJson(): array
    {
        return [
            ['expected_json.txt', 'file1.json', 'file2.json'],
            ['expected_json.txt', 'file1.yml', 'file2.yml']
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProvider')]
    public function testGenDiffDefault($expectedFile, $file1, $file2)
    {
        $expected = $this->getFixtureContent($expectedFile);
        $actual = genDiff("tests/fixtures/$file1", "tests/fixtures/$file2");
        $this->assertEquals($expected, $actual);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProviderStylish')]
    public function testGenDiffStylish($expectedFile, $file1, $file2)
    {
        $expected = $this->getFixtureContent($expectedFile);
        $actual = genDiff("tests/fixtures/$file1", "tests/fixtures/$file2", 'stylish');
        $this->assertEquals($expected, $actual);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProviderPlain')]
    public function testGenDiffPlain($expectedFile, $file1, $file2)
    {
        $expected = $this->getFixtureContent($expectedFile);
        $actual = genDiff("tests/fixtures/$file1", "tests/fixtures/$file2", 'plain');
        $this->assertEquals($expected, $actual);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProviderJson')]
    public function testGenDiffJson($expectedFile, $file1, $file2)
    {
        $expected = $this->getFixtureContent($expectedFile);
        $actual = genDiff("tests/fixtures/$file1", "tests/fixtures/$file2", 'json');
        $this->assertEquals($expected, $actual);
    }
}