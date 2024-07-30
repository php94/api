<?php

declare(strict_types=1);

namespace App\Php94\Api\Http\Api;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Form\Field\Text;
use PHP94\Form\Field\Textarea;
use PHP94\Form\Form;
use PHP94\Help\Request;
use PHP94\Help\Response;

class Create extends Common
{
    public function get()
    {
        $form = new Form('新增接口');
        $form->addItem(
            (new Text('路径', 'path'))->setRequired(),
            (new Text('标题', 'title'))->setRequired(),
            (new Textarea('简介', 'description')),
        );
        return $form;
    }

    public function post()
    {
        Db::insert('php94_api_api', [
            'path' => Request::post('path'),
            'title' => Request::post('title'),
            'description' => Request::post('description'),
        ]);
        return Response::success('操作成功！');
    }
}
