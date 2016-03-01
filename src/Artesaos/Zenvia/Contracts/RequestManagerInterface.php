<?php

namespace Artesaos\Zenvia\Contracts;


use Artesaos\Zenvia\RequestManager;
use Http\Client\HttpClient;

interface RequestManagerInterface
{
    /**
     * Send a request.
     *
     * @param string $method
     * @param string $uri
     * @param array  $headers
     * @param string $body
     * @param string $protocolVersion
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     */
    public function sendRequest($method, $uri, array $headers = [], $body = null, $protocolVersion = '1.1');

    /**
     * @param \Http\Client\HttpClient $httpClient
     * @return RequestManager
     */
    public function setHttpClient(HttpClient $httpClient);
}