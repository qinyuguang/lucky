<?php
namespace Svc;

use Model\Coin as MC;

class Coin
{
    public function listHistory($type, $minutes)
    {
        $datetime = date('Y-m-d H:i:00', strtotime("$minutes minutes ago"));
        return (new MC)->listHistory($type, $datetime);
    }

}

