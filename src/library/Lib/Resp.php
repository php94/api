<?php

declare(strict_types=1);

namespace App\Php94\Api\Lib;

use PHP94\Facade\Db;
use PHP94\Help\Request;
use PHP94\Help\Response;
use Psr\Http\Message\ResponseInterface;

class Resp
{
    public static function success($data = []): ResponseInterface
    {
        Db::insert('php94_api_log', [
            'code' => Request::get('code'),
            'path' => Request::get('path'),
            'error' => 0,
            'method' => $_SERVER['REQUEST_METHOD'] ?? null,
            'date' => date('Y-m-d'),
            'datetime' => date('Y-m-d H:i:s'),
        ]);
        return Response::json([
            'error' => 0,
            'data' => $data,
        ]);
    }

    public static function error(string $message, int $error = 1): ResponseInterface
    {
        Db::insert('php94_api_log', [
            'code' => Request::get('code'),
            'path' => Request::get('path'),
            'error' => $error,
            'message' => $message,
            'method' => $_SERVER['REQUEST_METHOD'] ?? null,
            'date' => date('Y-m-d'),
            'datetime' => date('Y-m-d H:i:s'),
        ]);
        return Response::json([
            'error' => $error,
            'message' => $message,
        ]);
    }
}
