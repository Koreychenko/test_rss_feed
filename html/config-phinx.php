<?php
$settings = require __DIR__ . '/app/config/config.php';
return [
    'paths' => [
        'migrations' => 'migrations/database'
    ],
    'migration_base_class' => '\Migrations\Migration',
    'environments' => [
        'default_database' => 'dev',
        'dev' => [
            'adapter' => $settings['db']['driver'],
            'host' => $settings['db']['host'],
            'name' => $settings['db']['database'],
            'user' => $settings['db']['username'],
            'pass' => $settings['db']['password'],
            'port' => $settings['db']['port']
        ]
    ]
];