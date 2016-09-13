<?php
require 'vendor/autoload.php';

define("APP_PATH", __DIR__);
define("STATIC_PATH", __DIR__."/bin/client");

$hs = new App\Service\HTTPService();
$hs->run();
