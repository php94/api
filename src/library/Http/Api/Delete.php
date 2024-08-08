<?php

declare(strict_types=1);

namespace App\Php94\Api\Http\Api;

use App\Php94\Admin\Http\Common;
use PHP94\Db;
use PHP94\Request;
use PHP94\Response;

class Delete extends Common
{
    public function get()
    {
        if ($api = Db::get('php94_api_api', '*', [
            'id' => Request::get('id'),
        ])) {
            Db::delete('php94_api_api', [
                'id' => $api['id'],
            ]);
            Db::delete('php94_api_access', [
                'api_id' => $api['id'],
            ]);
        }
        return Response::success('操作成功！');
    }
}
