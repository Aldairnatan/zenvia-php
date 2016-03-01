<?php

namespace Artesaos\Zenvia\Contracts;


interface SMSInterface
{
    /**
     * Send a SMS
     *
     * @param array $body
     * @param string $responseFormat The response format must be one of: array, json, string, stream, psr7
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(array $body, $responseFormat = 'json');
}