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


    private $url = 'https://private-anon-4abaa2a33-zenviasms.apiary-mock.com/';

    /**
     * {@inheritdoc}
     */
    public function sendRequest($method, $uri, array $body = [], $access_code, $protocolVersion = '1.1')
    {
        $request = MessageFactoryDiscovery::find()->createRequest($method, $this->url.$uri, ['Authorization'=>'Basic '.$access_code,'Content-Type'=>'application-json','Accept'=>'application/json'], json_encode($body), $protocolVersion);
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