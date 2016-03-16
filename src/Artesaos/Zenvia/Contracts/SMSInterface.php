<?php

namespace Artesaos\Zenvia\Contracts;


interface SMSInterface
{
    /**
     * Send a SMS
     *
     * @param array $body
     * @param null $aggregateId
     * @param string $responseFormat The response format must be one of: array, obj, string, stream, psr7, simple_xml
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(array $body,$aggregateId = null, $responseFormat = 'psr7');

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

    /**
     * Check the status of a delivered sms
     *
     * @param string $id             The SMS id
     * @param string $responseFormat The response format must be one of: array, obj, string, stream, psr7, simple_xml
     * @return mixed
     */
    public
    function check($id, $responseFormat = 'psr7');
}