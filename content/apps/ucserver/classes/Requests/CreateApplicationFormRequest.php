<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/8
 * Time: 1:43 PM
 */

namespace Ecjia\App\Ucserver\Requests;

use Ecjia\System\Frameworks\Requests\EcjiaFormRequest;

class CreateApplicationFormRequest extends EcjiaFormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'url' => 'required|url'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '应用名称不能为空',
            'url.required'  => '接口URL地址不能为空',
            'url.url'  => '接口URL地址不合法, 请返回更换',
            'ip.ip'  => 'IP地址不合法',
        ];
    }


}