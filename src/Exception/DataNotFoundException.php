<?php

declare(strict_types=1);

namespace Doctolib\Exception;

class DataNotFoundException extends \RuntimeException implements \Throwable
{
    private const DEFAULT_MESSAGE = 'Data not found.';

    public function __construct($message = self::DEFAULT_MESSAGE, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
