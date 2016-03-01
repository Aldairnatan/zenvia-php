<?php
namespace Artesaos\Zenvia;

use Artesaos\Zenvia\Contracts\ResponseHandlerInterface;
use Artesaos\Zenvia\Exceptions\ZenviaRequestException;
use Artesaos\Zenvia\Exceptions\ZenviaResponseException;
use Psr\Http\Message\ResponseInterface;

class ReponseHandler implements ResponseHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function convert(ResponseInterface $response, $format)
    {
        switch ($format) {
            case 'array':
                return $this->convertToArray($response);
            case 'string':
                return $response->getBody()->__toString();
            case 'simple_xml':
                return $this->convertToSimpleXml($response);
            case 'stream':
                return $response->getBody();
            case 'psr7':
                return $response;
            default:
                throw new \InvalidArgumentException('Format "%s" is not supported', $format);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function convertToArray(ResponseInterface $response)
    {
        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToSimpleXml(ResponseInterface $response)
    {
        $body = $response->getBody();
        try {
            return new \SimpleXMLElement((string) $body ?: '<root />');
        } catch (\Exception $e) {
            throw new ZenviaResponseException('Unable to parse response body into XML.');
        }
    }
}