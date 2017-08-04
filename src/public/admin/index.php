<?php

define('DOC_ROOT',  realpath(dirname(__FILE__) . '/../../').DIRECTORY_SEPARATOR);
define('APP_PATH',  realpath(DOC_ROOT.'/apps/admin').DIRECTORY_SEPARATOR);
define('LIB_PATH',  realpath(DOC_ROOT.'/library').DIRECTORY_SEPARATOR);

define('USER',  strtolower(get_current_user()));

require 'vendor/autoload.php';

$app  = new Yaf\Application(DOC_ROOT.'/conf/application.ini');
$app->bootstrap()->run();

