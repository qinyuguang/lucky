<?php
require 'ControllerCase.php';

class IndexTest extends ControllerCase
{
    public function testIndex()
    {
        $response   = $this->getResponseBody('index', 'index');

        $this->assertNotEmpty($response);
    }

}

