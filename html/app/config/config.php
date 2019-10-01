<?php

define('DB_ADAPTER','mysql');
define('DB_NAME','rssfeed');
define('DB_HOST','db');
define('DB_PORT',3306);
define('DB_USER','root');
define('DB_PASS','root');

$container['settings'] = [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => true,
        'db' => [
            'driver' => DB_ADAPTER,
            'host' => DB_HOST,
            'database' => DB_NAME,
            'username' => DB_USER,
            'password' => DB_PASS,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
    ];
