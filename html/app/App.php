<?php

namespace App;

use App\Controllers\FeedController;
use App\Controllers\Middlewares\AuthMiddleware;
use App\Controllers\RegisterController;
use App\Services\TimeService;
use Illuminate\Container\Container;
use Slim\Factory\AppFactory;
use App\Controllers\Middlewares\JsonBodyParseMiddleware;
use Illuminate\Database\Capsule\Manager;
use App\Services\AuthService;


class App
{
    /**
     * @var \Slim\App
     */
    private $app;

    /**
     * App constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $container = $this->getContainer($config);

        $app = AppFactory::create(null, $container);

        $app->post('/api/login', RegisterController::class . ':loginAction');
        $app->post('/api/register', RegisterController::class . ':registerAction');
        $app->post('/api/check-email', RegisterController::class . ':checkEmailAction');
        $app->get('/api/feed', FeedController::class . ':getFeedAction')->add(new AuthMiddleware($container));

        $app->add(new JsonBodyParseMiddleware);

        $this->app = $app;
    }

    /**
     * @return \Slim\App
     */
    public function get()
    {
        return $this->app;
    }

    public function getContainer(array $config)
    {
        $container = new Container();

        $container['settings'] = $config;

        $container['db'] = function ($container) {
            $capsule = new Manager;
            $capsule->addConnection($container['settings']['db']);

            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            return $capsule;
        };

        $container[AuthService::class] = function ($c) {
            $table = $c->get('db')->table('token');

            $faketime = null;
            if (isset($c->get('settings')['fakeTime'])) {
                $faketime = $c->get('settings')['fakeTime'];
            }
            $timeService = new TimeService($faketime);

            return new AuthService($table, $timeService);
        };

        $container[RegisterController::class] = function ($c) {
            $table = $c->get('db')->table('users');
            $authService = $c->get(AuthService::class);
            return new RegisterController($table, $authService);
        };

        $container[FeedController::class] = function ($c) {
            $feedUrl = $c->get('settings')['feedUrl'];
            $top50wordsWikiPage = $c->get('settings')['top50wordsWikiPage'];
            $cache = $c->get('settings')['wordsCache'];
            return new FeedController($feedUrl, $top50wordsWikiPage, $cache);
        };

        return $container;
    }
}