<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiffWithFlatJson()
    {
        $file1 = __DIR__ . '/fixtures/file1.json';
        $file2 = __DIR__ . '/fixtures/file2.json';
        $expected = file_get_contents(__DIR__ . '/fixtures/expected_flat.txt');

        $this->assertEquals($expected, genDiff($file1, $file2));
    }

    public function testGenDiffWithEmptyFiles()
    {
        $file1 = __DIR__ . '/fixtures/empty1.json';
        $file2 = __DIR__ . '/fixtures/empty2.json';
        $expected = "{\n}";

        $this->assertEquals($expected, genDiff($file1, $file2));
    }

    public function testGenDiffWithSameFiles()
    {
        $file = __DIR__ . '/fixtures/file1.json';
        $expected = file_get_contents(__DIR__ . '/fixtures/expected_same.txt');

        $this->assertEquals($expected, genDiff($file, $file));
    }

    public function testGenDiffWithDifferentTypes()
    {
        $file1 = __DIR__ . '/fixtures/file_types1.json';
        $file2 = __DIR__ . '/fixtures/file_types2.json';
        $expected = file_get_contents(__DIR__ . '/fixtures/expected_types.txt');

        $this->assertEquals($expected, genDiff($file1, $file2));
    }

    public function testGenDiffWithNonExistentFile()
    {
        $this->expectException(\Exception::class);
        genDiff('non_existent_file.json', 'another_non_existent_file.json');
    }
}
