<?php

declare(strict_types=1);

namespace Doctolib\Test;

use Doctolib\SerializerFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @covers \Doctolib\SerializerFactory
 *
 * @internal
 */
class SerializerFactoryTest extends TestCase
{
    public function testItCreatesASerializer(): void
    {
        $serializer = SerializerFactory::create();

        $this->assertInstanceOf(SerializerInterface::class, $serializer);
        $this->assertInstanceOf(DenormalizerInterface::class, $serializer);
    }
}
