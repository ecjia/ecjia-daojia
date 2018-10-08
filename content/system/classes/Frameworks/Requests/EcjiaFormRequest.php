<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/8
 * Time: 2:43 PM
 */

namespace Ecjia\System\Frameworks\Requests;

use Royalcms\Component\Foundation\Http\FormRequest;
use ecjia;
use ecjia_admin;

abstract class EcjiaFormRequest extends FormRequest
{

    /**
     * 可选: 重写基类方法
     * 如果需要自定义在验证失败时的行为, 可以重写这个方法
     */
    public function response(array $errors)
    {
        $message = '';
        foreach ($errors as $key => $error) {
            foreach ($error as $value) {
                $message .= $value . '<br />';
            }
        }

        if ($this->ajax() || $this->wantsJson()) {
            return ecjia_admin::$controller->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        return parent::response($errors);
    }


}