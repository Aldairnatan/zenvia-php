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
     * @param string $format
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
     * @return object StdClass
     */
    public static function convertToObj(ResponseInterface $response);


    /**
     * @param $data
     * @param string $rootNodeName
     * @param null $xml
     * @return \SimpleXMLElement
     *
     */
    public static function convertToSimpleXml($data, $rootNodeName = 'root', $xml = null);


    /**
     * Handle with HTTP errors
     * @param ResponseInterface $request
     * @return
     * @internal param ResponseInterface $response
     */
    public static function handleWithErrors(ResponseInterface $request);
}
