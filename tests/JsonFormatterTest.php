<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use Differ\Formatters\Json;

class JsonFormatterTest extends TestCase
{
    public function testJsonFormat()
    {
        $diff = [
            'common' => [
                'setting1' => 'Value 1',
                'setting2' => '200',
                'setting3' => true
            ],
            'group1' => [
                'baz' => 'bas',
                'foo' => 'bar'
            ]
        ];

        $expected = json_encode($diff, JSON_PRETTY_PRINT);
        $this->assertEquals($expected, Json\format($diff));
    }
}
