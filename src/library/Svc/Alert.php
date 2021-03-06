<?php
namespace Svc;

class Alert
{
    const TREND = ['up'=>'涨幅', 'down'=>'跌幅'];

    public function send($hits)
    {
        $hits = $this->groupByMail($hits);

        foreach ($hits as $groupId => $group) {
            $messages = [];
            foreach ($group as $item) {
                $messages[] = $this->getMessage($item);
            }

            if ($messages) {
                $message = implode(PHP_EOL, $messages);

                $result = $this->sendMail($groupId, $message);
                if (! $result) {
                    Logkit\Logger::ins('alert')->warning('发送邮件失败');
                }
            }
        }

        return true;
    }

    private function getMessage($hit)
    {
        return sprintf('%s提醒: %d分钟内%s超过%d%%, 达到%d%%!', strtoupper($hit['type']), $hit['period'], self::TREND[$hit['trend']], $hit['percent'], $hit['rate']);
    }

    private function sendMail($mailGroup, $message)
    {
        $swiftmailer = \Yaf\Application::app()->getConfig()->swiftmailer;

        $subject    = 'Coin预警';
        $to         = \Yaf\Application::app()->getConfig()->alertmail->$mailGroup;
        $to         = explode(',', $to);
        $from       = $swiftmailer->username;
        $pwd        = $swiftmailer->password;

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom([$from=>'Lucky Monitor'])
            ->setTo($to)
            ->setBody($message);

        $transport = \Swift_SmtpTransport::newInstance($swiftmailer->smtp, $swiftmailer->port, 'ssl')
            ->setUsername($from)
            ->setPassword($pwd);

        $mailer = \Swift_Mailer::newInstance($transport);

        $result = $mailer->send($message);

        return (bool) $result;
    }

    private function groupByMail($hits)
    {
        $result = [];

        foreach ($hits as $hit) {
            $result[$hit['mailgroup']][] = $hit;
        }

        return $result;
    }

}

