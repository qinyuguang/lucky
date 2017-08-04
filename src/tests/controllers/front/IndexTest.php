<?php
require 'ControllerCase.php';

class IndexTest extends ControllerCase
{
    public function testIndex()
    {
        $expect     = 'hello world';

        $response   = $this->getResponseBody('index', 'index');

        $this->assertEquals($expect, $response);
    }

}

