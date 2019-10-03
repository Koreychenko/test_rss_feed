<?php

use Illuminate\Container\Container;
use Slim\Factory\AppFactory;
use App\Controllers\Middlewares\JsonBodyParseMiddleware;

require __DIR__ . '/../../vendor/autoload.php';

$container = new Container();
require __DIR__ . '/../../app/config/config.php';
require __DIR__ . '/../../app/config/container.php';

$app = AppFactory::create(null, $container);

require __DIR__ . '/../../app/config/routing.php';

$app->add(new JsonBodyParseMiddleware);

$app->run();