<?php

declare(strict_types=1);

namespace App\Php94\Api\Http\Token;

use App\Php94\Admin\Http\Common;
use PHP94\Db;
use PHP94\Form\Field\Datetime;
use PHP94\Form\Field\Radio;
use PHP94\Form\Field\Radios;
use PHP94\Request;
use PHP94\Form\Field\Text;
use PHP94\Form\Field\Textarea;
use PHP94\Form\Form;
use PHP94\Response;

class Create extends Common
{
    public function get()
    {
        $form = new Form('添加令牌');
        $form->addItem(
            (new Text('令牌名称', 'title'))->setRequired(),
            (new Textarea('备注', 'description')),
            (new Text('令牌密钥', 'code', $this->getRandStr(64)))->setReadonly(),
            (new Datetime('有效期', 'expire_at', date('Y-m-d H:i:s', time() + 86400 * 30))),
            (new Radios('是否禁用', 'disabled', 0))->addRadio(
                new Radio('是', 1),
                new Radio('否', 0),
            ),
        );
        return $form;
    }

    public function post()
    {
        Db::insert('php94_api_token', [
            'title' => Request::post('title'),
            'description' => Request::post('description'),
            'code' => Request::post('code'),
            'expire_at' => Request::post('expire_at'),
            'disabled' => Request::post('disabled'),
        ]);
        return Response::success('操作成功！');
    }

    private function getRandStr(int $length): string
    {
        $str = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $len = strlen($str) - 1;
        $randstr = '';
        for ($i = 0; $i < $length; $i++) {
            $num = mt_rand(0, $len);
            $randstr .= $str[$num];
        }
        return $randstr;
    }
}
