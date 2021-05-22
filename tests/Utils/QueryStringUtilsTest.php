<?php

declare(strict_types=1);

namespace Doctolib\Test\Utils;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Doctolib\Test\Utils\QueryStringUtils
 *
 * @internal
 */
class QueryStringUtilsTest extends TestCase
{
    public function testCreateQueryStringFromArrayWithNestedArray(): void
    {
        $this->assertSame(
            '/foo/bar.json?id=123&foo%5B%5D=bar&foo%5B%5D=baz',
            QueryStringUtils::createUrlWithQueryString('/foo/bar.json', [
                'id' => 123,
                'foo' => ['bar', 'baz'],
            ])
        );
    }

    public function testCreateQueryStringFromEmptyArray(): void
    {
        $this->assertSame(
            '/foo/bar.json',
            QueryStringUtils::createUrlWithQueryString('/foo/bar.json', [])
        );
    }
}
