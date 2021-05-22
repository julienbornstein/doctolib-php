<?php

declare(strict_types=1);

namespace Doctolib\Exception;

class UnavailableSlotException extends \RuntimeException implements \Throwable
{
    public function __construct()
    {
        parent::__construct('Unavailable Slot');
    }
}
