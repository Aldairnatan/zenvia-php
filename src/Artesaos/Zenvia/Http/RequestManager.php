<?php

namespace Artesaos\Zenvia\Http;

use Artesaos\Zenvia\Contracts\RequestManagerInterface;
use Artesaos\Zenvia\Exceptions\ZenviaRequestException;
use Http\Client\Exception\TransferException;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;

class RequestManager implements RequestManagerInterface
{
    /**
     * @var \Http\Client\HttpClient
     */
    private $httpClient;

    /**
     * {@inheritdoc}
     */
    public function sendRequest($method, $uri, array $headers = [], $body = null, $protocolVersion = '1.1')
    {
        $request = MessageFactoryDiscovery::find()->createRequest($method, $uri, $headers, $body, $protocolVersion);
        try {
            return $this->getHttpClient()->sendRequest($request);
        } catch (TransferException $e) {
            throw new ZenviaRequestException('Error while requesting data from Zenvia API: '.$e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    /**
     * @return HttpClient
     */
    protected function getHttpClient()
    {
        if ($this->httpClient === null) {
            $this->httpClient = HttpClientDiscovery::find();
        }
        return $this->httpClient;
    }
}