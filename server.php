<?php
error_reporting(E_ALL & ~E_NOTICE);

require 'vendor/autoload.php';

define("APP_PATH", __DIR__);
define("STATIC_PATH", __DIR__."/bin/client");

//$a = new App\entity\User();

$ws = new App\Service\WSocketService();
$ws->run();


//$hs = new App\Service\HTTPService();
//$hs->run();
