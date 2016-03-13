<?php

namespace Artesaos\Zenvia\Http;

use Artesaos\Zenvia\Contracts\RequestManagerInterface;
use Artesaos\Zenvia\Exceptions\ZenviaRequestException;
use Carbon\Carbon;
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

    private $url;

    public function __construct()
    {
        $this->setUrl('https://private-anon-4abaa2a33-zenviasms.apiary-mock.com/');
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest($method, $uri, array $body = [], $access_code, $protocolVersion = '1.1')
    {
        $request = MessageFactoryDiscovery::find()->createRequest($method, $this->getUrl().$uri, ['authorization'=>"Basic $access_code",'content-type'=>'application/json','accept'=>'application/json'], json_encode($body), $protocolVersion);
        try {
            $response = ResponseHandler::convert($this->getHttpClient()->sendRequest($request),'psr7');

            ResponseHandler::handleWithErrors($response);
            return $response;
        } catch (TransferException $e) {
            throw new ZenviaRequestException('Error while requesting data from Zenvia API: '.$e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function convertDateFormatFromArrayField(array $data, $field, $format)
    {
        if(isset($data['sendSmsRequest'][$field])){
            $data['sendSmsRequest'][$field] = (new Carbon($data['sendSmsRequest'][$field]))->format($format);
            return $data;
        }elseif(isset($data['sendSmsMultiRequest']['sendSmsRequestList'])){
            foreach($data['sendSmsMultiRequest']['sendSmsRequestList'] as &$value){
                if($value[$field]){
                    $value[$field] = (new Carbon($value[$field]))->format($format);
                }
            }
            $data = array_intersect_key($data, array_flip(array_filter(array_keys($data), 'is_string')));
        }
        return $data;
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
     * @throws ZenviaRequestException
     */
    public function getHttpClient()
    {
        if ($this->httpClient === null) {
            $this->httpClient = HttpClientDiscovery::find();
            if ($this->httpClient === null){
                throw new ZenviaRequestException('The RequestManager expects a valid Http Client or Adapter, none given. Please install a valid Http Client or Adapter');
            }
        }
        return $this->httpClient;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $url
     * @return mixed
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
