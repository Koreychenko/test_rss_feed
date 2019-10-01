<?php

// Service factory for the ORM
$container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

$container[App\Controllers\RegisterController::class] = function ($c) {
    $table = $c->get('db')->table('users');
    return new App\Controllers\RegisterController($table);
};
