<?php
namespace Svc;

class Monitor
{
    public function hit($config)
    {
        $hits = [];

        $group = $this->periodGroup($config);

        $coinSvc    = new Coin;

        foreach ($group as $item) {
            $data = $coinSvc->listHistory($item['platform'], $item['type'], $item['period']);

            foreach ($item['target'] as $target) {
                $rate = $this->isHit($data, $target);
                if ($rate !== false) {
                    $hits[] = [
                        'type'      => $item['type'],
                        'period'    => $item['period'],
                        'trend'     => $target['trend'],
                        'percent'   => $target['percent'],
                        'rate'      => $rate,
                        'mailgroup' => $target['mailgroup'],
                    ];
                }
            }
        }

        return $hits;
    }

    private function periodGroup($config)
    {
        $result = [];

        foreach ($config as $item) {
            $groupKey = $item['platform'].':'.$item['type'].':'.$item['period'];

            $result[$groupKey][] = [
                'trend'     => $item['trend'],
                'percent'   => $item['percent'],
                'mailgroup' => $item['mailgroup'],
            ];
        }

        $group = [];
        foreach ($result as $key=>$value) {
            list($platform, $type, $period) = explode(':', $key);
            $group[] = [
                'platform'  => $platform,
                'type'      => $type,
                'period'    => $period,
                'target'    => $value,
            ];
        }

        return $group;
    }

    private function isHit($data, $target)
    {
        if (count($data) < 2) {
            return false;
        }

        $first  = array_shift($data)['price'];
        $last   = array_pop($data)['price'];

        $trend  = ($last > $first) ? 'up' : 'down';

        $percent = abs(($last - $first) / $first) * 100;

        return ($target['trend'] == $trend && $percent > $target['percent']) ? $percent : false;
    }

}

