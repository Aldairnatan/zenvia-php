<?php
namespace Artesaos\Zenvia\Tests;

use Mockery as m;
use Artesaos\Zenvia\Tests\Traits\MockTrait;
use Artesaos\Zenvia\Http\RequestManager;

class RequestManagerTest extends \PHPUnit_Framework_TestCase
{
    use MockTrait;

    private $requestManager;

    public function setUp()
    {
        $this->requestManager = new RequestManager();
    }

    public function test_if_api_url_is_set_up_by_default()
    {
        $this->assertNotEmpty($this->requestManager->getUrl());
    }

    public function test_can_change_api_url()
    {
        $newUrl = "http://myapi.app/";
        $this->requestManager->setUrl($newUrl);
        $this->assertEquals($newUrl, $this->requestManager->getUrl());
    }

    public function test_if_can_get_a_valid_http_client()
    {
        $this->assertInstanceOf(\Http\Client\HttpClient::class, $this->requestManager->getHttpClient());
    }


}