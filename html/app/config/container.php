<?php

// Service factory for the ORM
use Illuminate\Database\Capsule\Manager;
use App\Services\AuthService;
use App\Controllers\RegisterController;
use App\Controllers\FeedController;

$container['db'] = function ($container) {
    $capsule = new Manager;
    $capsule->addConnection($container['settings']['db']);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

$container[App\Services\AuthService::class] = function ($c) {
    $table = $c->get('db')->table('token');
    return new AuthService($table);
};

$container[RegisterController::class] = function ($c) {
    $table = $c->get('db')->table('users');
    $authService = $c->get(AuthService::class);
    return new RegisterController($table, $authService);
};

$container[FeedController::class] = function ($c) {
    $feedUrl = $c->get('settings')['feedUrl'];
    $top50wordsWikiPage = $c->get('settings')['top50wordsWikiPage'];
    return new FeedController($feedUrl, $top50wordsWikiPage);
};