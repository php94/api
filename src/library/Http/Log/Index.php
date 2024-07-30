<?php

declare(strict_types=1);

namespace App\Php94\Api\Http\Log;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Facade\Template;
use PHP94\Help\Request;

class Index extends Common
{
    public function get()
    {
        $data = [];
        $where = [];
        if (strlen(Request::get('code', ''))) {
            $where['code'] = Request::get('code');
        }
        if (strlen(Request::get('path', ''))) {
            $where['path'] = Request::get('path');
        }
        if (Request::get('q')) {
            $where['OR'] = [
                'error' => Request::get('q'),
                'message[~]' => Request::get('q'),
            ];
        }
        $data['total'] = Db::count('php94_api_log', $where);

        $data['page'] = Request::get('page', 1) ?: 1;
        $data['size'] = Request::get('size', 20) ?: 20;
        $data['pages'] = ceil($data['total'] / $data['size']) ?: 1;
        $where['LIMIT'] = [($data['page'] - 1) * $data['size'], $data['size']];
        $where['ORDER'] = [
            'id' => 'ASC',
        ];
        $logs = Db::select('php94_api_log', '*', $where);
        $data['datas'] = $logs;

        return Template::render('log/index@php94/api', $data);
    }
}
