<?php

declare(strict_types=1);

namespace App\Php94\Api\Http;

use App\Php94\Api\Lib\Resp;
use PHP94\Db;
use PHP94\Logger;
use PHP94\Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class Api implements RequestHandlerInterface
{
    public function handle(
        ServerRequestInterface $request
    ): ResponseInterface {
        try {
            $code = $this->getCode();
            if (!is_string($code) || !strlen(trim($code))) {
                return Resp::error('token无效', 52001);
            }

            if (!$token = Db::get('php94_api_token', '*', [
                'code' => $code,
            ])) {
                return Resp::error('token无效', 51001);
            }

            if (date('Y-m-d H:i:s') > $token['expire_at']) {
                return Resp::error('token失效', 51002);
            }

            if ($token['disabled']) {
                return Resp::error('token无效', 51003);
            }

            if (!$api = Db::get('php94_api_api', '*', [
                'path' => Request::get('path', ''),
            ])) {
                return Resp::error('无权限', 53000);
            }

            $method = strtolower($request->getMethod());
            if (!Db::get('php94_api_access', '*', [
                'token_id' => $token['id'],
                'api_id' => $api['id'],
                'methods[~]' => '"' . $method . '"',
            ])) {
                if (!Db::get('php94_api_access', '*', [
                    'token_id' => $token['id'],
                    'api_id' => $api['id'],
                ])) {
                    return Resp::error('无权限', 53001);
                } else {
                    return Resp::error('无权限', 53002);
                }
            }

            if (!isset($api['code_' . $method]) || is_null($api['code_' . $method])) {
                return Resp::error('方法不支持', 54000);
            }

            try {
                $resp = $this->exec($api['code_' . $method]);
                if (is_a($resp, ResponseInterface::class)) {
                    return $resp;
                } else {
                    return Resp::error('接口错误', 55000);
                }
            } catch (Throwable $th) {
                Logger::error($th->getMessage(), $th->getTrace());
                return Resp::error('接口错误', 54001);
            }
        } catch (Throwable $th) {
            Logger::error($th->getMessage(), $th->getTrace());
            return Resp::error('系统发生错误', 50000);
        }
    }

    private function exec(string $code)
    {
        $code .= <<<'str'
function success($data)
{
    return App\Php94\Api\Lib\Resp::success($data);
}
function error(string $message, int $errcode = 1)
{
    return App\Php94\Api\Lib\Resp::error($message, $errcode);
}
str;
        ob_start();
        $res = eval($code);
        ob_get_clean();
        return $res;
    }

    private function getCode(): string
    {
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            return substr($_SERVER['HTTP_AUTHORIZATION'], 7);
        } elseif (isset($_SERVER['Authorization'])) { // 一些服务器可能会用这个
            return substr($_SERVER['Authorization'], 7);
        } else {
            return Request::get('code', '');
        }
    }
}
