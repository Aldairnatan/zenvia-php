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
}