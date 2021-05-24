<?php

declare(strict_types=1);

namespace Doctolib\Test\Utils;

use Doctolib\Utils\UrlUtils;
use Monolog\Test\TestCase;

/**
 * @internal
 * @covers \Doctolib\Utils\UrlUtils
 */
class UrlUtilsTest extends TestCase
{
    public function dataProviderPaths(): iterable
    {
        yield ['/a/b/c', 'c'];

        yield ['/foo', null];
    }

    /**
     * @dataProvider dataProviderPaths
     *
     * @param mixed $expected
     */
    public function testGetSlugFromPath(string $path, $expected): void
    {
        $this->assertSame($expected, UrlUtils::getSlugFromPath($path));
    }
}
