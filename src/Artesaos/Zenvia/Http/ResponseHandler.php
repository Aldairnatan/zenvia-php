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
            case 'json':
                return self::convertToJson($response);
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
    public static function convertToJson(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents());
    }

    /**
     * {@inheritdoc}
     */
    public static function convertToSimpleXml($data, $rootNodeName = 'root', $xml = null) {
        if($data instanceof ResponseInterface){
            $data = self::convertToArray($data);
        }

        try {
            if ($xml == null) {
                $xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
            }

            foreach ($data as $key => $value) {
                if (is_numeric($key)) {
                    $key = "unknownNode_" . (string) $key;
                }

                $key = preg_replace('/[^a-z]/i', '', $key);


                if (is_array($value)) {
                    $node = $xml->addChild($key);
                    self::convertToSimpleXml($value, $rootNodeName, $node);
                } else {
                    $value = htmlentities($value);
                    $xml->addChild($key, $value);
                }
            }
            return $xml->asXML();
        } catch (\Exception $e) {
            throw new ZenviaResponseException('Unable to parse response body into XML.');
        }
    }
}