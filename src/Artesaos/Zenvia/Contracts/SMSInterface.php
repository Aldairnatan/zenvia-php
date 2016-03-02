<?php

namespace Artesaos\Zenvia\Contracts;


interface SMSInterface
{
    /**
     * Send a SMS
     *
     * @param array $body
     * @param string $responseFormat The response format must be one of: array, obj, string, stream, psr7, simple_xml
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(array $body, $responseFormat = 'psr7');

    /**
     * Send multiple SMS
     *
     * @param array $data An array of sms for send
     * @param null $aggregateId
     * @param string $responseFormat The response format must be one of: array, obj, string, stream, psr7, simple_xml
     * @return \Psr\Http\Message\ResponseInterface
     * @internal param array $sms
     * @internal param array $body
     */
    public function sendMultiple(array $data,$aggregateId = null, $responseFormat = 'psr7');
}