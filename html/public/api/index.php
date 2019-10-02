<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';

$container = new \Illuminate\Container\Container();
require __DIR__ . '/../../app/config/config.php';
require __DIR__ . '/../../app/config/container.php';

$app = AppFactory::create(null, $container);

$app->add(new Tuupola\Middleware\CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => ["*"],
    "credentials" => true,
    "cache" => 86400
]));
$app->add(new \App\Controllers\Middlewares\JsonBodyParseMiddleware);
$app->add(new \App\Controllers\Middlewares\AuthMiddleware($container, [
    'exclude' => [
        '/api/check-email',
        '/api/register',
        '/api/login'
    ]
]));

require __DIR__ . '/../../app/config/routing.php';

$app->run();