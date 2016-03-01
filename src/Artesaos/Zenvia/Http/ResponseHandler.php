<?php
namespace Artesaos\Zenvia\Http;

use Artesaos\Zenvia\Contracts\ResponseHandlerInterface;
use Artesaos\Zenvia\Exceptions\ZenviaResponseException;
use Psr\Http\Message\ResponseInterface;

class ResponseHandler implements ResponseHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public static function convert(ResponseInterface $response, $format)
    {
        switch ($format) {
            case 'array':
                return self::convertToArray($response);
            case 'string':
                return $response->getBody()->__toString();
            case 'simple_xml':
                return self::convertToSimpleXml($response);
            case 'stream':
                return $response->getBody();
            case 'psr7':
                return $response;
            default:
                throw new \InvalidArgumentException('Format '.$format.'is not supported');
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function convertToArray(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * {@inheritdoc}
     */
    public static function convertToSimpleXml(ResponseInterface $response)
    {
        $body = $response->getBody()->getContents();
        try {
            return new \SimpleXMLElement((string) $body ?: '<root />');
        } catch (\Exception $e) {
            throw new ZenviaResponseException('Unable to parse response body into XML.');
        }
    }
}