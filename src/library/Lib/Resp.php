<?php

declare(strict_types=1);

namespace App\Php94\Api\Lib;

use PHP94\Db;
use PHP94\Request;
use PHP94\Response;
use Psr\Http\Message\ResponseInterface;

class Resp
{
    public static function success($data = []): ResponseInterface
    {
        return Response::json([
            'error' => 0,
            'data' => $data,
        ]);
    }

    public static function error(string $message, int $error = 1): ResponseInterface
    {
        return Response::json([
            'error' => $error,
            'message' => $message,
        ]);
    }
}
