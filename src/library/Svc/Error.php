<?php
namespace Svc;

class Error
{
    //系统
    const NOT_FOUND                 = 404;
    const UNAVAILABLE               = 503;

    const UNKOWN                    = 9999;

    public static $message = [
        self::NOT_FOUND                 => 'Page Not Found',
        self::UNAVAILABLE               => 'Service Unavailable',

        self::UNKOWN                    => '未知错误',
    ];

    static public function getMessage($errno)
    {
        if ($errno && isset(self::$message[$errno])) {
            return self::$message[$errno];
        }

        return self::$message[self::UNKOWN];
    }
}

