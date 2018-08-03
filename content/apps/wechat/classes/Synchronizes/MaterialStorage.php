<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/19
 * Time: 4:07 PM
 */

namespace Ecjia\App\Wechat\Synchronizes;

use InvalidArgumentException;

class MaterialStorage
{

    protected $material;

    protected $allow_types = ['news', 'image', 'voice', 'video'];

    public function __construct($wechat_id, $type, $data, $wechat)
    {
        if (! in_array($type, $this->allow_types)) {
            throw new InvalidArgumentException(sprintf("素材类型%s不支持！", $type));
        }

        $className = __NAMESPACE__ . sprintf("\\%sMaterialStorage", ucfirst($type));

        $this->material = new $className($wechat_id, $type, $data, $wechat);
    }


    public function save()
    {
        $this->material->save();
    }


}