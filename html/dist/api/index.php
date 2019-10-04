<?php

require __DIR__ . '/../../vendor/autoload.php';

$config = require __DIR__ . '/../../app/config/config.php';

$app = new App\App($config);

$app->get()->run();