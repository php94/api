<?php

declare(strict_types=1);

namespace App\Php94\Api\Http\Api;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Form\Field\Codemirror;
use PHP94\Form\Field\Hidden;
use PHP94\Form\Field\Text;
use PHP94\Form\Form;
use PHP94\Help\Request;
use PHP94\Help\Response;

class Code extends Common
{
    public function get()
    {
        $api = Db::get('php94_api_api', '*', [
            'id' => Request::get('id'),
        ]);
        $method = Request::get('method');

        $form = new Form('设置代码');
        $form->addItem(
            (new Hidden('id', $api['id'])),
            (new Text('方法', 'methods', $method))->setDisabled(),
            (new Codemirror('代码', 'code', $api['code_' . $method]))
                ->setHelp('请返回Psr\Http\Message\ResponseInterface实例，便捷方法：success($data)或者error(int $errcode, string $message)'),
        );
        return $form;
    }

    public function post()
    {
        $update = [];
        $code = Request::post('code', '');
        $method = Request::get('method', '');
        if (is_string($code) && strlen($code)) {
            $update['code_' . $method] = $code;
        } else {
            $update['code_' . $method] = null;
        }
        Db::update('php94_api_api', $update, [
            'id' => Request::post('id'),
        ]);
        return Response::success('操作成功！');
    }
}
