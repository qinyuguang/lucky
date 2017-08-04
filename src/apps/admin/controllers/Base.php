<?php

class BaseController extends Yaf\Controller_Abstract
{
    public function init()
    {
        /*
        //缓存静态资源版本
        $version = Cache\Cache::ins()->fetch('VERSION');
        if ($version === false) {
            $version = time();
            Cache\Cache::ins()->save('VERSION', $version, 604800);
        }

        $this->_view->staticVersion = $version;
         */

        $this->_view->staticVersion = trim(file_get_contents(DOC_ROOT.'/../version'));;

        //ace skin
        $this->_view->aceSkin       = htmlspecialchars($this->getRequest()->getCookie('ace_skin', 'no-skin'));

        $this->_view->config        = Yaf\Registry::get('config');
    }
}

