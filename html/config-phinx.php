<?php
require __DIR__ . '/app/config/config.php';
return [
    'paths' => [
        'migrations' => 'migrations/database'
    ],
    'migration_base_class' => '\Migrations\Migration',
    'environments' => [
        'default_database' => 'dev',
        'dev' => [
            'adapter' => DB_ADAPTER,
            'host' => DB_HOST,
            'name' => DB_NAME,
            'user' => DB_USER,
            'pass' => DB_PASS,
            'port' => DB_PORT
        ]
    ]
];