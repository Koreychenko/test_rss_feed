<?php
$app->post('/api/login', \App\Controllers\RegisterController::class . ':loginAction');
$app->post('/api/register', \App\Controllers\RegisterController::class . ':registerAction');
$app->post('/api/check-email', \App\Controllers\RegisterController::class . ':checkEmailAction');
$app->get('/api/feed', \App\Controllers\FeedController::class . ':getFeedAction');

