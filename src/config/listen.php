<?php

use App\Php94\Api\Http\Api;
use Composer\Autoload\ClassLoader;
use PHP94\Logger;
use PHP94\Logger\LocalLogger;
use PHP94\Router\Router;

return [
    Router::class => function (
        Router $router
    ) {
        $router->addGroup('/api', function (Router $router) {
            $router->addGroup('/{code:[a-zA-Z0-9]{64}}', function (Router $router) {
                $router->addRoute('{path:[\s\S]+}', Api::class, '/php94/api/api');
            });
        });
        $root = dirname((new ReflectionClass(ClassLoader::class))->getFileName(), 3);
        Logger::addLogger(new LocalLogger($root . '/runtime/log'));
    }
];
