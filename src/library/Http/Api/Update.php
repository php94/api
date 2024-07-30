<?php

declare(strict_types=1);

namespace App\Php94\Api\Http\Api;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Form\Field\Hidden;
use PHP94\Form\Field\Text;
use PHP94\Form\Field\Textarea;
use PHP94\Form\Form;
use PHP94\Help\Request;
use PHP94\Help\Response;

class Update extends Common
{
    public function get()
    {
        $app = Db::get('php94_api_api', '*', [
            'id' => Request::get('id'),
        ]);

        $form = new Form('更新项目信息');
        $form->addItem(
            (new Hidden('id', $app['id'])),
            (new Text('路径', 'path', $app['path']))->setRequired(),
            (new Text('标题', 'title', $app['title']))->setRequired(),
            (new Textarea('简介', 'description', $app['description'])),
        );
        return $form;
    }

    public function post()
    {
        Db::update('php94_api_api', [
            'path' => Request::post('path'),
            'title' => Request::post('title'),
            'description' => Request::post('description'),
        ], [
            'id' => Request::post('id'),
        ]);
        return Response::success('操作成功！');
    }
}
