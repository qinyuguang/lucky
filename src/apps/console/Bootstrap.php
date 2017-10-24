<?php
use Libyaf\Helper\Cookie;

class Bootstrap extends Yaf\Bootstrap_Abstract
{
    public function _initConfig($dispatcher)
    {
        $config = Yaf\Application::app()->getConfig();
    	Yaf\Registry::set('config', $config);
    }

    public function _initRoute($dispatcher)
    {
    	// $route = Yaf\Dispatcher::getInstance()->getRouter();
    	// $route->addConfig(Yaf\Registry::get('config')->routes);
    }

    public function _initLoader($dispatcher)
    {
        $localNameSpace = [
            'Model',
            'Svc',
        ];

    	Yaf\Loader::getInstance()->registerLocalNamespace($localNameSpace);
    }

    public function _initPlugin($dispatcher)
    {
        $dispatcher->registerPlugin(new RequestPlugin());
    }

    public function _initView($dispatcher)
    {
        $dispatcher->disableView();
    }

    public function _initHeader($dispatcher)
    {
        header('Content-Type:text/html; charset=utf-8');
        header('X-Frame-Options: sameorigin');

        $request = $dispatcher->getRequest();

        if ($request->isXmlHttpRequest()) {
            header('Content-Type:application/json; charset=utf-8');
        }

        if ($request->get('callback')) {
            header('Content-Type:text/javascript; charset=utf-8');
            echo ' '.htmlspecialchars($request->get('callback'));
        }
    }

    public function _initCookie($dispatcher)
    {
        $config = Yaf\Registry::get('config')->cookie;

        if ($config) {
            Cookie::$salt       = (string)  $config->salt;
            Cookie::$expiration = (int)     $config->expire;
            Cookie::$path       = (string)  $config->path;
            Cookie::$domain     = (string)  $config->domain;
            Cookie::$secure     = (bool)    $config->secure;
            Cookie::$httponly   = (bool)    $config->httponly;
        }
    }

}

