<?php

declare(strict_types=1);

namespace Doctolib\Exception;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class AuthenticationException extends \RuntimeException implements ClientExceptionInterface
{
    private ResponseInterface $response;

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;

        $code = $response->getInfo('http_code');
        $url = $response->getInfo('url');
        $message = sprintf('HTTP %d returned for "%s".', $code, $url);

        $body = json_decode($response->getContent(false), true);

        if (isset($body['error'])) {
            $message = $body['error'];
        }

        parent::__construct($message, $code);
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
