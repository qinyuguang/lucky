<?php
use Svc\Monitor;
use Svc\Alert;

class MonitorController extends Yaf\Controller_Abstract
{
    public function indexAction()
    {
        // 获取配置
        $config = Yaf\Application::app()->getConfig()->monitor;
        \Helper\Debug::vars($config);

        if (! $config) {
            return false;
        }

        // 遍历命中
        $hits = (new Monitor)->hit($config);

        // 发送消息
        (new Alert)->send($hits);

        return false;
    }
}

