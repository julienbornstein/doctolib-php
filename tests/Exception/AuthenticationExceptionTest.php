<?php

declare(strict_types=1);

namespace Doctolib\Test\Exception;

use Doctolib\Exception\AuthenticationException;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @internal
 * @covers \Doctolib\Exception\AuthenticationException
 */
class AuthenticationExceptionTest extends TestCase
{
    use ProphecyTrait;

    public function testGetResponseReturnTheResponseInstance(): void
    {
        $response = $this->createResponseProphecy();
        $response->getContent(false)->shouldBeCalledOnce()->willReturn('[]');

        $e = new AuthenticationException($response->reveal());

        $this->assertInstanceOf(ResponseInterface::class, $e->getResponse());
    }

    public function testResponseWithErrorPropertySetExceptionMessage(): void
    {
        $response = $this->createResponseProphecy();
        $response->getContent(false)->shouldBeCalledOnce()->willReturn('{"error": "foo bar error"}');

        $e = new AuthenticationException($response->reveal());

        $this->assertSame('foo bar error', $e->getMessage());
    }

    private function createResponseProphecy(): ObjectProphecy
    {
        $responseProphecy = $this->prophesize(ResponseInterface::class);
        $responseProphecy->getInfo('http_code')->shouldBeCalledOnce()->willReturn(401);
        $responseProphecy->getInfo('url')->shouldBeCalledOnce()->willReturn('http://foo.com');

        return $responseProphecy;
    }
}
