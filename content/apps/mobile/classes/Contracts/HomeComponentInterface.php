<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-18
 * Time: 16:13
 */
namespace Ecjia\App\Mobile\Contracts;

interface HomeComponentInterface
{

    /**
     * 获取首页默认模块组件
     * @return mixed
     */
    public function getHomeComponent();


    /**
     * 获取首页定义允许使用的模块组件
     * @return mixed
     */
    public function getDefinedHomeComponent();

}