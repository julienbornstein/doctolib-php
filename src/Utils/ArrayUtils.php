<?php

declare(strict_types=1);

namespace Doctolib\Utils;

class ArrayUtils
{
    public static function renameKey(array $array, string $oldKey, string $newKey): array
    {
        foreach ($array as $key => $value) {
            if (\is_array($value)) {
                $array[$key] = \call_user_func(__METHOD__, $value, $oldKey, $newKey);
            } else {
                $array[$newKey] = $array[$oldKey];
            }
        }
        unset($array[$oldKey]);

        return $array;
    }

    public static function searchCollectionItemById(array $collection, int $id): ?array
    {
        foreach ($collection as $item) {
            if (false === \array_key_exists('id', $item)) {
                throw new \UnexpectedValueException('array must have a "id" key');
            }

            if ($id === $item['id']) {
                return $item;
            }
        }

        return null;
    }
}
