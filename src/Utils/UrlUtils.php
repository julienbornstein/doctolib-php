<?php

declare(strict_types=1);

namespace Doctolib\Utils;

class UrlUtils
{
    public static function getSlugFromPath(string $path): ?string
    {
        $regex = '#^/([a-z0-9]+(?:-[a-z0-9]+)*)/([a-z0-9]+(?:-[a-z0-9]+)*)/([a-z0-9]+(?:-[a-z0-9]+)*)#';
        preg_match($regex, $path, $matches);

        if (4 === \count($matches)) {
            return $matches[3];
        }

        return null;
    }
}
