<?php
namespace Svc;

class Rest
{
    private static $result = [
        'errno'     => Error::UNKOWN,
        'errmsg'    => '',
        'data'      => null,
    ];

    public static function success($data = null)
    {
        self::$result['errno'] = 0;

        if ($data !== null) {
            self::$result['data'] = $data;
        }

        if ($_GET['callback']) {
            echo '('.json_encode(self::$result).')';
        } else {
            echo json_encode(self::$result);
        }
    }

    public static function fail($errmsg, $errno, $data = null)
    {
        self::$result['errno']  = intval($errno);
        self::$result['errmsg'] = (string) $errmsg;

        if ($data !== null) {
            self::$result['data'] = $data;
        }

        if ($_GET['callback']) {
            echo '('.json_encode(self::$result).')';
        } else {
            echo json_encode(self::$result);
        }
    }

}

