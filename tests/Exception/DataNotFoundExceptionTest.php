<?php

declare(strict_types=1);

namespace Doctolib\Test\Exception;

use Doctolib\Exception\DataNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers \Doctolib\Exception\DataNotFoundException
 */
class DataNotFoundExceptionTest extends TestCase
{
    public function testItReturnDefaultMessage(): void
    {
        $e = new DataNotFoundException();

        $this->assertSame('Data not found.', $e->getMessage());
    }
}
