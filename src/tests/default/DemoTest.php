<?php
use Svc\Rest;

class DemoTest extends PHPUnit_Framework_TestCase
{
    public function testConfig()
    {
        $projName = Yaf\Application::app()->getConfig()->projName;

        $this->assertNotEmpty($projName);
    }

    public function testRest()
    {
        $data = ['result'=>true];

        $result = json_encode([
            'errno'     => 0,
            'errmsg'    => '',
            'data'      => [
                'result' => true,
            ]
        ]);

        Rest::success($data);

        $this->expectOutputString($result);
    }

}

