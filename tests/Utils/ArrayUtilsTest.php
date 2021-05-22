<?php

declare(strict_types=1);

namespace Doctolib\Test\Utils;

use Doctolib\Utils\ArrayUtils;
use Monolog\Test\TestCase;

/**
 * @covers \Doctolib\Utils\ArrayUtils
 *
 * @internal
 */
class ArrayUtilsTest extends TestCase
{
    public function testReplaceKey(): void
    {
        $array = ['a' => 'value a'];

        $this->assertEquals(['z' => 'value a'], ArrayUtils::renameKey($array, 'a', 'z'));
    }

    public function testReplaceKeyInNestedArray(): void
    {
        $array = [
            'a' => 'value a',
            'b' => [
                'a' => 'nested value a',
            ],
        ];

        $expected = [
            'z' => 'value a',
            'b' => [
                'z' => 'nested value a',
            ],
        ];

        $this->assertEquals($expected, ArrayUtils::renameKey($array, 'a', 'z'));
    }

    public function testSearchCollectionItemByIdReturnItem(): void
    {
        $collection = [
            ['id' => 1, 'name' => 'foo'],
        ];

        $item = ArrayUtils::searchCollectionItemById($collection, 1);

        $this->assertSame('foo', $item['name']);
    }

    public function testSearchCollectionItemByIdReturnNullIfNotFound(): void
    {
        $collection = [
            ['id' => 1, 'name' => 'foo'],
        ];

        $item = ArrayUtils::searchCollectionItemById($collection, 2);

        $this->assertNull($item);
    }

    public function testSearchCollectionItemByIdThrowsExceptionIfArrayHaveNoIdKey(): void
    {
        $collection = [
            ['name' => 'foo'],
        ];

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('array must have a "id" key');

        ArrayUtils::searchCollectionItemById($collection, 1);
    }
}
