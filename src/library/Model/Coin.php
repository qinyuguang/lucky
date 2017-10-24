<?php
namespace Model;

use Libyaf\Database\Database;

class Coin
{
    public function listHistory($platform, $type, $datetime)
    {
        return Database::ins()
            ->createQueryBuilder()
            ->select('*')
            ->from($platform)
            ->where('type=:type')->setParameter(':type', $type)
            ->andWhere('ftime > :ftime')->setParameter(':ftime', $datetime)
            ->execute()
            ->fetchAll();
    }

    public function getLastestValue($type)
    {
        return Database::ins()
            ->createQueryBuilder()
            ->select('*')
            ->from('btc38')
            ->where('type=:type')->setParameter(':type', $type)
            ->orderBy('id', 'DESC')
            ->setMaxResults(1)
            ->execute()
            ->fetch();
    }

}

