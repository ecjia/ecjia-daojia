<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/9/6
 * Time: 10:26 AM
 */

namespace Ecjia\App\Goods;

use ecjia_installer;

class Installer extends ecjia_installer
{
    protected $dependent = array(
        'ecjia.system' => '1.0'
    );


    public function __construct()
    {
        $id = 'ecjia.goods';
        parent::__construct($id);
    }

    /**
     * 安装
     * @return bool
     */
    public function install()
    {

        return true;
    }

    /**
     * 卸载
     * @return bool
     */
    public function uninstall()
    {

        return true;
    }

    /**
     * 升级
     * @return bool
     */
    public function upgrade()
    {

        return true;
    }

}