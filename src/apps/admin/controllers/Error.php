<?php
use Svc\Error;
use Svc\Rest;

class ErrorController extends BaseController
{
    public function errorAction($exception)
    {
        try {
            throw $exception;
        } catch (Yaf\Exception\LoadFailed $e) {
            header('HTTP/1.0 404 Not Found', true, 404);

            $logger = Logkit\Logger::ins('_exception');
            $logger->debug($e->getMessage());

            $this->getView()->display('error/404.html');
        } catch (Doctrine\DBAL\DBALException $e) {
            header('500 Internal Server Error', true, 500);

            $logger = Logkit\Logger::ins('_exception');
            $logger->error($e->getMessage());

            $this->getView()->display('error/500.html');
        } catch (InvalidArgumentException $e) {
            Rest::fail($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            header('500 Internal Server Error', true, 500);

            $logger = Logkit\Logger::ins('_exception');
            $logger->error($e->getMessage());

            $this->getView()->display('error/500.html');
        }

        return false;
    }

}

