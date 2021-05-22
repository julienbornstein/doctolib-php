<?php

declare(strict_types=1);

namespace Doctolib\DataDenormalizer;

interface DataDenormalizerInterface
{
    public static function denormalize(array $data): array;
}
