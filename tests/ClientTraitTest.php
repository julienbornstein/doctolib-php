<?php

declare(strict_types=1);

namespace Doctolib\Test;

use Doctolib\Client;
use Doctolib\Exception\UnavailableSlotException;
use Monolog\Test\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @covers \Doctolib\Client
 *
 * @internal
 */
class ClientTraitTest extends TestCase
{
    use ProphecyTrait;

    public function testInvalidContentTypeThrowsException(): void
    {
        $responses = [
            new MockResponse('{}'),
        ];

        $httpClient = new MockHttpClient($responses);
        $serializer = $this->prophesize(SerializerInterface::class);

        $client = new Client($httpClient, $serializer->reveal());
        $client->setSessionId('test-session-id');

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Server returned response in non-JSON format.');

        $client->getMasterPatient();
    }

    public function testSerializerShouldImplementDenormalizer(): void
    {
        $responses = [
            FixtureGenerator::createMockJsonResponse(),
        ];

        $httpClient = new MockHttpClient($responses);
        $serializer = $this->prophesize(SerializerInterface::class);

        $client = new Client($httpClient, $serializer->reveal());
        $client->setSessionId('test-session-id');

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Serializer is not a Denormalizer.');

        $client->getMasterPatient();
    }

    public function testErrorInResponseThrowsException(): void
    {
        $responses = [
            FixtureGenerator::createMockJsonResponse(json_encode([
                'error' => 'an error',
            ])),
        ];

        $httpClient = new MockHttpClient($responses);
        $serializer = $this->prophesize(SerializerInterface::class);

        $client = new Client($httpClient, $serializer->reveal());
        $client->setSessionId('test-session-id');

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('an error');

        $client->getMasterPatient();
    }

    /**
     * @covers \Doctolib\Client::checkApiError
     * @covers \Doctolib\Exception\UnavailableSlotException
     */
    public function testUnavailableSlotErrorResponseThrowsException(): void
    {
        $responses = [
            FixtureGenerator::createMockJsonResponse(json_encode([
                'error' => 'unavailable_slot',
            ])),
        ];

        $httpClient = new MockHttpClient($responses);
        $serializer = $this->prophesize(SerializerInterface::class);

        $client = new Client($httpClient, $serializer->reveal());
        $client->setSessionId('test-session-id');

        $this->expectException(UnavailableSlotException::class);
        $this->expectExceptionMessage('Unavailable Slot');

        $client->getMasterPatient();
    }
}
