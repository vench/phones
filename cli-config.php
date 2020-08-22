<?php


require __DIR__ . '/vendor/autoload.php';

use App\App;
use App\Config;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$app = new App();
$app->runCli();

$config = $app->getObject(Config::class);

return ConsoleRunner::createHelperSet($config->createEntityManager());
