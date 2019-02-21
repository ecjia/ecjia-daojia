<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 10:08
 */

namespace Ecjia\App\Mobile\Contracts;


interface ApplicationOptionInterface
{

    /**
     * 获取所有选项
     * @return array
     */
    public function getOptions();

    /**
     * 获取单个选项值
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function getOption($key, $default = null);

}