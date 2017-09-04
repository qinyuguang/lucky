<?php
namespace Svc;

use Model\Coin as MC;

class Coin
{
    public function listHistory($platform, $type, $minutes)
    {
        $datetime = date('Y-m-d H:i:00', strtotime("$minutes minutes ago"));
        return (new MC)->listHistory($platform, $type, $datetime);
    }

    public function getLastestValue($type)
    {
        return (new MC)->getLastestValue($type);
    }

}

