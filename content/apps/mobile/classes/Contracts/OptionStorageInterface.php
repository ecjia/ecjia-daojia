<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 09:18
 */

namespace Ecjia\App\Mobile\Contracts;


interface OptionStorageInterface
{

    /**
     * 保存选项值
     * @param $key
     * @param $value
     * @return mixed
     */
    public function saveOption($key, $value, $hander = null);

    /**
     * 获取选项值
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function getOption($key, $default = null);


    /**
     * 删除选项值
     * @param $key
     * @return mixed
     */
    public function deleteOption($key);


}