<?php

namespace Artesaos\Zenvia\Contracts;


interface SMSInterface
{
    /**
     * Send a SMS
     *
     * @param $uri
     * @param array $headers
     * @param null $body
     * @param string $protocolVersion
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send($uri, array $headers = [], $body = null, $protocolVersion = '1.1');
}