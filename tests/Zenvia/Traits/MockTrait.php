<?php
namespace Artesaos\Zenvia\Tests\Traits;

use Mockery as m;
trait MockTrait
{

    /**
     * @afterClass
     */
    public function tearDown()
    {
        m::close();
    }
}