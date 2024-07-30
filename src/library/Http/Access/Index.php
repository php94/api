<?php

declare(strict_types=1);

namespace App\Php94\Api\Http\Access;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Facade\Template;
use PHP94\Help\Request;

class Index extends Common
{
    public function get()
    {
        $data = [];

        $data['token'] = Db::get('php94_api_token', '*', [
            'id' => Request::get('token_id', '')
        ]);

        $datas = Db::select('php94_api_access', '*', [
            'token_id' => Request::get('token_id', ''),
            'ORDER' => [
                'id' => 'ASC',
            ]
        ]);
        $selectedapi = [];
        foreach ($datas as &$vo) {
            $vo['api'] = Db::get('php94_api_api', '*', [
                'id' => $vo['api_id'],
            ]);
            $vo['token'] = Db::get('php94_api_token', '*', [
                'id' => $vo['token_id'],
            ]);
            $selectedapi[] = $vo['api_id'];
        }
        unset($vo);
        $data['datas'] = $datas;

        $where = [
            'LIMIT' => 20,
        ];
        if ($selectedapi) {
            $where['id[!]'] = $selectedapi;
        }
        $q = Request::get('q', '');
        if (is_string($q) && strlen(trim($q))) {
            $where['OR'] = [
                'title[~]' => trim($q),
                'description[~]' => trim($q),
            ];
        }
        $data['apis'] = Db::select('php94_api_api', '*', $where);

        return Template::render('access/index@php94/api', $data);
    }
}
