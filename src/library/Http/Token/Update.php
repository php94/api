<?php

declare(strict_types=1);

namespace App\Php94\Api\Http\Token;

use App\Php94\Admin\Http\Common;
use PHP94\Db;
use PHP94\Form\Field\Datetime;
use PHP94\Request;
use PHP94\Form\Field\Hidden;
use PHP94\Form\Field\Radio;
use PHP94\Form\Field\Radios;
use PHP94\Form\Field\Text;
use PHP94\Form\Field\Textarea;
use PHP94\Form\Form;
use PHP94\Response;

class Update extends Common
{
    public function get()
    {
        $token = Db::get('php94_api_token', '*', [
            'id' => Request::get('id'),
        ]);
        $form = new Form('编辑令牌');
        $form->addItem(
            (new Hidden('id', $token['id'])),
            (new Text('令牌名称', 'title', $token['title']))->setRequired(),
            (new Textarea('备注', 'description', $token['description'])),
            (new Datetime('有效期', 'expire_at', $token['expire_at'])),
            (new Radios('是否禁用', 'disabled', $token['disabled']))->addRadio(
                new Radio('是', 1),
                new Radio('否', 0),
            ),
        );
        return $form;
    }

    public function post()
    {
        $token = Db::get('php94_api_token', '*', [
            'id' => Request::post('id'),
        ]);

        Db::update('php94_api_token', [
            'title' => Request::post('title'),
            'description' => Request::post('description'),
            'expire_at' => Request::post('expire_at'),
            'disabled' => Request::post('disabled'),
        ], [
            'id' => $token['id'],
        ]);

        return Response::success('操作成功！');
    }
}
