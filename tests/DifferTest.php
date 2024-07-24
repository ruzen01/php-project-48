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
            ['json'],
            ['yml']
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProvider')]
    public function testGenDiffDefault($format)
    {
        $expected = $this->getFixtureContent('expected_default.txt');
        $actual = genDiff("tests/fixtures/file1.$format", "tests/fixtures/file2.$format");
        $this->assertEquals($expected, $actual);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProvider')]
    public function testGenDiffStylish($format)
    {
        $expected = $this->getFixtureContent('expected_stylish.txt');
        $actual = genDiff("tests/fixtures/file1.$format", "tests/fixtures/file2.$format", 'stylish');
        $this->assertEquals($expected, $actual);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProvider')]
    public function testGenDiffPlain($format)
    {
        $expected = $this->getFixtureContent('expected_plain.txt');
        $actual = genDiff("tests/fixtures/file1.$format", "tests/fixtures/file2.$format", 'plain');
        $this->assertEquals($expected, $actual);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProvider')]
    public function testGenDiffJson($format)
    {
        $expected = $this->getFixtureContent('expected_json.txt');
        $actual = genDiff("tests/fixtures/file1.$format", "tests/fixtures/file2.$format", 'json');
        $this->assertEquals($expected, $actual);
    }
}
