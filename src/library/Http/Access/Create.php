<?php

declare(strict_types=1);

namespace App\Php94\Api\Http\Access;

use App\Php94\Admin\Http\Common;
use PHP94\Db;
use PHP94\Form\Field\Checkbox;
use PHP94\Form\Field\Checkboxs;
use PHP94\Form\Field\Text;
use PHP94\Form\Form;
use PHP94\Request;
use PHP94\Response;

class Create extends Common
{
    public function get()
    {
        $token = Db::get('php94_api_token', '*', [
            'id' => Request::get('token_id', '')
        ]);
        $api = Db::get('php94_api_api', '*', [
            'id' => Request::get('api_id', '')
        ]);

        $form = new Form('新增授权');
        $form->addItem(
            (new Text('令牌', 'title', $token['title']))->setDisabled(),
            (new Text('接口', 'title', $api['title']))->setDisabled(),
            (new Checkboxs('授权方法', 'methods', []))->addCheckbox(
                new Checkbox('GET', 'get'),
                new Checkbox('HEAD', 'head'),
                new Checkbox('PUT', 'put'),
                new Checkbox('PATCH', 'patch'),
                new Checkbox('POST', 'post'),
                new Checkbox('TRACE', 'trace'),
                new Checkbox('OPTIONS', 'options'),
                new Checkbox('DELETE', 'delete'),
                new Checkbox('LOCK', 'lock'),
                new Checkbox('MKCOL', 'mkcol'),
                new Checkbox('COPY', 'copy'),
                new Checkbox('MOVE', 'move'),
            ),
        );
        return $form;
    }

    public function post()
    {
        if (Db::get('php94_api_access', '*', [
            'token_id' => Request::get('token_id'),
            'api_id' => Request::get('api_id'),
        ])) {
            return Response::error('无需重复授权');
        }
        Db::insert('php94_api_access', [
            'token_id' => Request::get('token_id'),
            'api_id' => Request::get('api_id'),
            'methods' => json_encode(Request::post('methods', []), JSON_UNESCAPED_UNICODE),
        ]);
        return Response::success('操作成功！');
    }
}
