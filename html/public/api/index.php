<?php

use Illuminate\Container\Container;
use Slim\Factory\AppFactory;
use Tuupola\Middleware\CorsMiddleware;
use App\Controllers\Middlewares\JsonBodyParseMiddleware;

require __DIR__ . '/../../vendor/autoload.php';

$container = new Container();
require __DIR__ . '/../../app/config/config.php';
require __DIR__ . '/../../app/config/container.php';

$app = AppFactory::create(null, $container);

$app->add(new CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => ["*"],
    "credentials" => true,
    "cache" => 86400
]));

require __DIR__ . '/../../app/config/routing.php';

$app->add(new JsonBodyParseMiddleware);

$app->run();