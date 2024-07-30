<?php

declare(strict_types=1);

namespace App\Php94\Api\Http\Access;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Help\Request;
use PHP94\Help\Response;

class Delete extends Common
{
    public function get()
    {
        if ($access = Db::get('php94_api_access', '*', [
            'id' => Request::get('id'),
        ])) {
            Db::delete('php94_api_access', [
                'id' => $access['id'],
            ]);
        }
        return Response::success('操作成功！');
    }
}
