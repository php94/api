<?php

declare(strict_types=1);

namespace App\Php94\Api\Http\Access;

use App\Php94\Admin\Http\Common;
use PHP94\Db;
use PHP94\Form\Field\Checkbox;
use PHP94\Form\Field\Checkboxs;
use PHP94\Form\Field\Hidden;
use PHP94\Form\Field\Text;
use PHP94\Form\Form;
use PHP94\Request;
use PHP94\Response;

class Update extends Common
{
    public function get()
    {
        $access = Db::get('php94_api_access', '*', [
            'id' => Request::get('id'),
        ]);

        $token = Db::get('php94_api_token', '*', [
            'id' => $access['token_id'],
        ]);
        $api = Db::get('php94_api_api', '*', [
            'id' => $access['api_id'],
        ]);

        $form = new Form('更新授权信息');
        $form->addItem(
            (new Hidden('id', $access['id'])),
            (new Text('令牌', 'title', $token['title']))->setDisabled(),
            (new Text('接口', 'title', $api['title']))->setDisabled(),
            (new Checkboxs('授权方法', 'methods', json_decode($access['methods'], true)))->addCheckbox(
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
        Db::update('php94_api_access', [
            'methods' => json_encode(Request::post('methods', []), JSON_UNESCAPED_UNICODE),
        ], [
            'id' => Request::post('id'),
        ]);
        return Response::success('操作成功！');
    }
}
