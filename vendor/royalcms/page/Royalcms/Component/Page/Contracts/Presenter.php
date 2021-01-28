<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/8/16
 * Time: 11:36 AM
 */

namespace Royalcms\Component\Page\Contracts;


interface Presenter
{
    /**
     * 上一页
     *
     * @return string
     */
    public function pre();

    /**
     * 下一页
     *
     * @return string
     */
    public function next();

    /**
     * 文字页码列表
     *
     * @return string
     */
    public function text_list();

    /**
     * 图标页码列表
     *
     * @return string
     */
    public function pic_list();

    /**
     * 选项列表
     *
     * @return string
     */
    public function select();

    /**
     * 输入框
     *
     * @return string
     */
    public function input();

    /**
     * 前几页
     *
     * @return string
     */
    public function pres();

    /**
     * 后几页
     *
     * @return string
     */
    public function nexts();

    /**
     * 首页
     *
     * @return string
     */
    public function first();

    /**
     * 末页
     *
     * @return string
     */
    public function end();

    /**
     * 当前页记录
     *
     * @return string
     */
    public function now_page();

    /**
     * count统计
     *
     * @return string
     */
    public function count();

}