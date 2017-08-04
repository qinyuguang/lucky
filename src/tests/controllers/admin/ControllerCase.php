<?php

class ControllerCase extends PHPUnit_Framework_TestCase
{
    protected function getResponseBody($controller, $action, array $params = [])
    {
        $request    = new Yaf\Request\Simple('CLI', 'Index', $controller, $action, $params);

        $dispatcher = Yaf\Application::app()->getDispatcher();

        $response   = $dispatcher->returnResponse(true)->dispatch($request);

        return $response->getBody();
    }

}

