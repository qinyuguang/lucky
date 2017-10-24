<?php

class RequestPlugin extends Yaf\Plugin_Abstract
{
    public function routerStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response)
    {
        //记录请求信息
        $logger = Libyaf\Logkit\Logger::ins('_request');

        //增加web请求信息
        $processor = new Monolog\Processor\WebProcessor();
        $logger->pushProcessor($processor);
        $logger->info('', $request->getPost());
    }

    public function routerShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response)
    {
    }

    public function dispatchLoopStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response)
    {
        ob_start();
    }

    public function preDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response)
    {
    }

    public function postDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response)
    {
    }

    public function dispatchLoopShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response)
    {
        $response->setBody(ob_get_clean());
    }

}

