<?php

use App\Php94\Admin\Model\Menu;
use App\Php94\Api\Http\Api;
use Composer\Autoload\ClassLoader;
use PHP94\Logger;
use PHP94\Logger\LocalLogger;
use PHP94\Router\Router;
use App\Php94\Api\Http\Token\Index as TokenIndex;
use App\Php94\Api\Http\Api\Index as ApiIndex;
use App\Php94\Api\Http\Log\Index as LogIndex;

return [
    Menu::class => function (
        Menu $menu
    ) {
        $menu->addMenu('令牌管理', TokenIndex::class);
        $menu->addMenu('接口管理', ApiIndex::class);
        $menu->addMenu('请求日志', LogIndex::class);
    },
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
