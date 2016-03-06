<?php
namespace Artesaos\Zenvia\Tests;

use Artesaos\Zenvia\Http\ResponseHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\ResponseInterface;

class ResponseHandlerTest extends \PHPUnit_Framework_TestCase
{
    private $response;

    public function setUp()
    {
        $body = '{"response": "example"}';
        $this->response = new Response(200,[],$body);
    }

    public function test_if_a_response_from_api_is_psr7()
    {
        $this->assertInstanceOf(ResponseInterface::class, $this->response);
    }

    public function test_if_a_response_can_be_converted_to_Array()
    {
        $convertedResponse = ResponseHandler::convert($this->response,'array');
        $this->assertTrue(is_array($convertedResponse));
    }

    public function test_if_a_response_can_be_converted_to_Obj()
    {
        $convertedResponse = ResponseHandler::convert($this->response,'obj');

        $this->assertInternalType('object', $this->response);
        $this->assertInstanceOf(\StdClass::class, $convertedResponse);
    }

    public function test_if_a_response_can_be_converted_to_Stream()
    {
        $convertedResponse = ResponseHandler::convert($this->response,'stream');
        $this->assertInstanceOf(Stream::class, $convertedResponse);
    }

    public function test_if_a_response_can_be_converted_to_SimpleXml()
    {
        $convertedResponse = ResponseHandler::convert($this->response,'simple_xml');

        $this->assertInstanceOf(\SimpleXmlElement::class,simplexml_load_string($convertedResponse));
        $this->assertEquals('example',simplexml_load_string($convertedResponse)->response);
    }

    public function test_if_a_exception_is_throw_on_convert_to_invalid_format()
    {
        $this->setExpectedException(\InvalidArgumentException::class,'Format invalid_format is not supported');

        $convertedResponse = ResponseHandler::convert($this->response,'invalid_format');
    }
}