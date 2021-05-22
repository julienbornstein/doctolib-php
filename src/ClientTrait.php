<?php

declare(strict_types=1);

namespace Doctolib;

use Doctolib\Exception\AuthenticationException;
use Doctolib\Exception\UnavailableSlotException;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

trait ClientTrait
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function checkJsonResponse(ResponseInterface $response): void
    {
        $headers = $response->getHeaders(false);
        $contentType = $headers['content-type'] ?? [];
        $contentType = $contentType[array_key_first($contentType)] ?? '';

        if (false === strpos($contentType, 'application/json')) {
            throw new \UnexpectedValueException('Server returned response in non-JSON format.');
        }
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws UnavailableSlotException
     */
    private function checkApiError(ResponseInterface $response): void
    {
        $content = $response->toArray();

        if (!\array_key_exists('error', $content)) {
            return;
        }

        $error = $content['error'];

        switch ($error) {
            case 'unavailable_slot':
                throw new UnavailableSlotException();
        }

        throw new \RuntimeException($error);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function checkAuth(ResponseInterface $response): void
    {
        $statusCode = $response->getStatusCode();

        if (401 === $statusCode) {
            throw new AuthenticationException($response);
        }
    }

    private function checkIsAuthenticated(): void
    {
        if (null === $this->sessionId) {
            throw new \RuntimeException('Not authenticated.');
        }
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function getCookieFromResponse(ResponseInterface $response, string $cookieName): ?Cookie
    {
        $responseHeaders = $response->getHeaders(false);
        $setCookie = $responseHeaders['set-cookie'] ?? [];

        foreach ($setCookie as $cookieStr) {
            $cookie = Cookie::fromString($cookieStr);

            if ($cookie->getName() === $cookieName) {
                return $cookie;
            }
        }

        return null;
    }

    /**
     * @throws ExceptionInterface
     */
    private function denormalize(array $data, string $type, string $format = 'json')
    {
        if (!$this->serializer instanceof DenormalizerInterface) {
            throw new \RuntimeException('Serializer is not a Denormalizer.');
        }

        return $this->serializer->denormalize($data, $type, $format);
    }
}
