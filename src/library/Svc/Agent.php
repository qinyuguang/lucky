<?php
namespace Svc;

use Model\Wallet as MW;

class Agent
{
    public function trade($hits)
    {
        if (! $hits) {
            return false;
        }

        $action = null;

        foreach ($hits as $target) {
            if ($target['period'] <= 30 && $target['trend'] == 'up' && $target['percent'] >= 5) {
                $action = 'sell';
                break;
            }

            if ($target['period'] <= 30 && $target['trend'] == 'down' && $target['percent'] >= 5) {
                $action = 'buy';
                break;
            }
        }

        if ($action) {
            $lastestValue = (new Coin)->getLastestValue('bts');

            $diff = time() - strtotime($lastestValue['ftime']);
            if ( $diff > 100) {
                return false;
            }

            $lastRecord = (new MW)->getLastestValue();

            return call_user_func([$this, $action], $lastestValue['price'], $lastRecord);
        }

        return false;
    }

    private function buy($price, $record)
    {
        if ($record['balance'] == 0) {
            return false;
        }

        $data = [
            'type'      => 'buy',
            'amount'    => $record['balance'] / $price,
            'balance'   => 0,
        ];

        return (new MW)->create($data);
    }

    private function sell($price, $record)
    {
        if ($record['amount'] == 0) {
            return false;
        }

        $data = [
            'type'      => 'sell',
            'amount'    => 0,
            'balance'   => $record['amount'] * $price,
        ];

        return (new MW)->create($data);
    }

}

