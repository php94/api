<?php

use App\Php94\Api\Http\Token\Index as TokenIndex;
use App\Php94\Api\Http\Api\Index as ApiIndex;
use App\Php94\Api\Http\Log\Index as LogIndex;

return [
    'menus' => [[
        'title' => '接口管理',
        'node' => ApiIndex::class,
    ], [
        'title' => '令牌管理',
        'node' => TokenIndex::class,
    ], [
        'title' => '请求日志',
        'node' => LogIndex::class,
    ]],
    'widgets' => [],
];
