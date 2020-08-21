<?php


require __DIR__ . '/vendor/autoload.php';

use \App\App;

$app = new App();
return $app->runCli();