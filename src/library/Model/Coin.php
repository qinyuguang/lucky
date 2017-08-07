<?php
namespace Model;

use Database\Database;

class Coin
{
    public function listHistory($type, $datetime)
    {
        return Database::ins()
            ->createQueryBuilder()
            ->select('*')
            ->from('btc38')
            ->where('type=:type')->setParameter(':type', $type)
            ->andWhere('ftime > :ftime')->setParameter(':ftime', $datetime)
            ->execute()
            ->fetchAll();
    }
}

