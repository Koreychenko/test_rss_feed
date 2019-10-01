<?php
$app->post('/register', \App\Controllers\RegisterController::class . ':registerAction');
$app->post('/check-email', \App\Controllers\RegisterController::class . ':checkEmailAction');

