<?php

declare(strict_types=1);

namespace Doctolib\Test\Utils;

class QueryStringUtils
{
    private static function createQueryString(array $queryArray): ?string
    {
        if (0 === \count($queryArray)) {
            return null;
        }

        $queryString = http_build_query($queryArray, '', '&', \PHP_QUERY_RFC3986);
        $queryString = preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '%5B%5D=', $queryString);

        return '' !== $queryString ? $queryString : null;
    }

    public static function createUrlWithQueryString(string $url, array $queryArray = []): string
    {
        $queryString = self::createQueryString($queryArray);

        if (\is_string($queryString)) {
            $url = sprintf('%s?%s', $url, $queryString);
        }

        return $url;
    }
}
