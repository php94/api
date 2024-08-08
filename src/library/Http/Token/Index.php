<?php

declare(strict_types=1);

namespace App\Php94\Api\Http\Token;

use App\Php94\Admin\Http\Common;
use PHP94\Db;
use PHP94\Template;
use PHP94\Request;

class Index extends Common
{
    public function get()
    {
        $data = [];
        $where = [];
        if (Request::get('q')) {
            $where['OR'] = [
                'code' => Request::get('q'),
                'title[~]' => Request::get('q'),
                'description[~]' => Request::get('q'),
            ];
        }
        $data['total'] = Db::count('php94_api_token', $where);

        $data['page'] = Request::get('page', 1) ?: 1;
        $data['size'] = Request::get('size', 20) ?: 20;
        $data['pages'] = ceil($data['total'] / $data['size']) ?: 1;
        $where['LIMIT'] = [($data['page'] - 1) * $data['size'], $data['size']];
        $where['ORDER'] = [
            'id' => 'ASC',
        ];
        $data['datas'] = Db::select('php94_api_token', '*', $where);

        return Template::render('token/index@php94/api', $data);
    }
}
