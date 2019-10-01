<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new \Illuminate\Container\Container();
require __DIR__ . '/../app/config/config.php';
require __DIR__ . '/../app/config/container.php';

$app = AppFactory::create(null, $container);

require __DIR__ . '/../app/config/routing.php';

$app->run();