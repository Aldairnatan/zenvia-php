<?php

namespace Artesaos\Zenvia\Contracts;

use Artesaos\Zenvia\Exceptions\ZenviaResponseException;
use Psr\Http\Message\ResponseInterface;

interface ResponseHandlerInterface
{

    /**
     * Convert a PSR-7 response to a data type you want to work with.
     *
     * @param ResponseInterface $response
     * @param string            $format
     *
     * @return ResponseInterface|\Psr\Http\Message\StreamInterface|\SimpleXMLElement|string
     *
     * @throws \InvalidArgumentException
     */
    public static function convert(ResponseInterface $response, $format);


    /**
     * @param ResponseInterface $response
     *
     * @return string
     */
    public static function convertToArray(ResponseInterface $response);


    /**
     * @param ResponseInterface $response
     *
     * @return \SimpleXMLElement
     *
     * @throws ZenviaResponseException
     */
    public static function convertToSimpleXml(ResponseInterface $response);
}