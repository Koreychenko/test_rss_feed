<?php

use App\Controllers\FeedController;
use App\Controllers\Middlewares\AuthMiddleware;
use App\Controllers\RegisterController;

$app->post('/api/login', RegisterController::class . ':loginAction');
$app->post('/api/register', RegisterController::class . ':registerAction');
$app->post('/api/check-email', RegisterController::class . ':checkEmailAction');
$app->get('/api/feed', FeedController::class . ':getFeedAction')->add(new AuthMiddleware($container));

