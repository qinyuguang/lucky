<?php
use Svc\Error;
use Svc\Rest;
use Libyaf\Logkit\Logger;

class ErrorController extends Yaf\Controller_Abstract
{
    public function errorAction()
    {
        try {
            throw $this->getRequest()->getException();
        } catch (Yaf\Exception\LoadFailed $e) {
            Rest::fail(Error::getMessage(Error::NOT_FOUND), Error::NOT_FOUND);
        } catch (Doctrine\DBAL\DBALException $e) {
            Rest::fail(Error::getMessage(Error::UNAVAILABLE), Error::UNAVAILABLE);

            $logger = Logger::ins('_dbal');
            $logger->error($e->getMessage());
        } catch (Exception $e) {
            Rest::fail($e->getMessage(), $e->getCode());

            $logger = Logger::ins('_exception');
            $logger->error($e->getMessage());
        }

        return false;
    }
}

