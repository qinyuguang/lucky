<?php
namespace Model;

use Database\Database;

class Wallet
{
    public function getLastestValue()
    {
        return Database::ins()
            ->createQueryBuilder()
            ->select('*')
            ->from('wallet')
            ->orderBy('id', 'DESC')
            ->setMaxResults(1)
            ->execute()
            ->fetch();
    }

    public function create($data)
    {
        Database::ins()->insert('wallet', $data);

        return Database::ins()->lastInsertId();
    }

}

