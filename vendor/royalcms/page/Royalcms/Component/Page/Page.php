<?php

namespace Royalcms\Component\Page;

use Royalcms\Component\Page\Contracts\Presenter;
use RC_Uri;
use RC_Config;

/**
 * 分页处理类
 *
 * @package Core
 */
abstract class Page implements Presenter
{

    protected static $static_total_pages = null; // 总页数
    protected static $static_url = null; // 当前url
    protected static $fix = ''; // 静态后缀如.html
    protected static $page_num_label = '{page}'; // 替换标签


    public $total_records; // 总条数
    public $total_pages; // 总页数
    public $page_size; // 每页显示数
    public $page_row; // 每页显示页码数
    public $current_page; // 当前页
    public $url; // 页面地址
    public $args; // 页面传递参数
    public $start_id; // 当前页开始ID
    public $end_id; // 当前页末尾ID
    public $desc = array(); // 文字描述

    protected $request;
    
    /**
     *
     * @param int $total
     *            总条数
     * @param string $row
     *            每页显示条数
     * @param string $page_row
     *            显示页码数量
     * @param string $desc
     *            描述文字
     * @param string $set_current_page
     *            当前页
     * @param string $custom_url
     *            自定义url地址
     * @param string $page_num_label
     *            页码变量,默认为{page}
     */
    function __construct($total, $row = '', $page_row = '', $desc = '', $set_current_page = '', $custom_url = '', $page_num_label = '{page}')
    {
        $this->total_records = $total; // 总条数
        $this->page_size = empty($row) ? RC_Config::get('system.page_show_row') : $row; // 每页显示条数
        $this->page_row = (empty($page_row) ? RC_Config::get('system.page_row') : $page_row) - 1; // 显示页码数量
        $this->total_pages = ceil($this->total_records / $this->page_size); // 总页数
        self::$static_total_pages = $this->total_pages; // 总页数
        self::$page_num_label = empty($page_num_label) ? self::$page_num_label : $page_num_label; // 替换标签
        $this->current_page = min($this->total_pages, empty($set_current_page) ? empty($_GET[RC_Config::get('system.page_var')]) ? 1 : max(1, (int) $_GET[RC_Config::get('system.page_var')]) : max(1, (int) $set_current_page)); // 当前页
        $this->url = $this->set_url($custom_url);
        $this->start_id = ($this->current_page - 1) * $this->page_size + 1; // 当前页开始ID
        $this->end_id = min($this->current_page * $this->page_size, $this->total_records); // 当前页结束ID
        $this->desc = $this->desc($desc);

//        $this->request = royalcms('request');

        // 配置url地址
//        $this->setUrl($custom_url);
    }



    /**
     *
     *
     *
     * 配置描述文字
     *
     * @param array $desc
     *            <code>
     *            "pre"	=>	"上一页"
     *            "next"	=>	"下一页"
     *            "pres"	=>	"前十页"
     *            "nexts"	=>	"下十页"
     *            "first"	=>	"首页"
     *            "end"	=>	"尾页"
     *            "unit"	=>	"条"
     *            </code>
     * @return array
     */
    private function desc($desc)
    {
        $this->desc = array_change_key_case(RC_Config::get('system.page_desc'));
        array_walk_recursive($this->desc, array($this, 'desc_gettext'));
        
        if (empty($desc) || ! is_array($desc))
            return $this->desc;
        
        return array_merge($this->desc, array_filter($desc, array(
            $this,
            'desc_filter'
        )));
    }

    private function desc_filter($v)
    {
        return ! empty($v);
    }
    
    private function desc_gettext(&$item, $key) {
       $item = __($item);
    }

    /**
     * 列表项
     *
     * @return string Ambigous mixed>
     */
    protected function page_list()
    {
        // 页码
        $page_list = [];
        $start = max(1, min($this->current_page - ceil($this->page_row / 2), $this->total_pages - $this->page_row));
        $end = min($this->page_row + $start, $this->total_pages);
        if ($end == 1) // 只有一页不显示页码
            return '';
        for ($i = $start; $i <= $end; $i ++) {
            if ($this->current_page == $i) {
                $page_list[$i]['url'] = "";
                $page_list[$i]['str'] = $i;
                continue;
            }
            $page_list[$i]['url'] = $this->get_url($i);
            $page_list[$i]['str'] = $i;
        }
        return $page_list;
    }

    /**
     * 获取URL地址
     *
     * @param unknown $page_num            
     * @return Ambigous <string, mixed, unknown>
     */
    protected function get_url($page_num)
    {
        $return_url = $this->url;
        /*
         * 数型返回url地址 b(before)返回url地址前部分 a(after)返回url地址后部分
         */
        if (strtolower($page_num) == 'b') {
            $return_url = substr($return_url, 0, strpos($return_url, self::$page_num_label));
        } elseif (strtolower($page_num) == 'a') {
            $return_url = substr($return_url, strpos($return_url, self::$page_num_label) + strlen(self::$page_num_label));
        } else {
            $return_url = str_replace(self::$page_num_label, $page_num, $return_url);
        }

        return $return_url;
    }

    /**
     * 移出路由默认变量
     * @param $querys
     */
    private function removeRouteQuerys(& $querys)
    {
        array_forget($querys, config('route.module'));
        array_forget($querys, config('route.controller'));
        array_forget($querys, config('route.action'));
        array_forget($querys, config('route.page'));
        array_forget($querys, config('route.lang'));
        array_forget($querys, config('route.route'));
    }

    /**
     * 配置URL地址
     * @param $url
     */
    public function setUrl($url)
    {
        if (! empty($url)) {
            $this->url = $url;
            return $this;
        }

        if (is_null(self::$static_url)) {
            $gets = $this->request->query();
            $this->removeRouteQuerys($gets);

            array_set($gets, config('route.page'), self::$page_num_label);

            $this->url = RC_Uri::url(sprintf("%s/%s/%s", ROUTE_M, ROUTE_C , ROUTE_A), $gets);
        } else {
            $this->url = self::$static_url . self::$fix; // 配置url地址
        }

        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    /**
     * 配置URL地址
     *
     * @param unknown $custom_url            
     * @return Ambigous <string, unknown>
     */
    protected function set_url($custom_url)
    {
        if (! empty($custom_url)) {
            $return_url = $custom_url;
        } elseif (is_null(self::$static_url)) {
            $get = $_GET;
            $this->unset_url_val($get);
            $url_type = RC_Config::get('system.url_mode');
            switch ($url_type) {
                case 'pathinfo':
                    $url = '/';
                    foreach ($get as $k => $v) {
                        $url .= $k . '/' . $v . '/';
                    }
                    $url = rtrim($url, '/') . '/' . RC_Config::get('system.page_var') . '/' . self::$page_num_label . self::$fix;
                    $return_url = RC_Uri::url(ROUTE_M . '/' . ROUTE_C . '/' . ROUTE_A . $url);
                    break;
                case 'normal':
                default:
                    $url = '';
                    foreach ($get as $k => $v) {
                        $url .= $k . "=" . $v . '&';
                    }
                    $url .= RC_Config::get('system.page_var') . '=' . self::$page_num_label;
                    $return_url = RC_Uri::url(ROUTE_M . '/' . ROUTE_C . '/' . ROUTE_A, $url);
                    break;
            }
        } else {
            $return_url = self::$static_url . self::$fix; // 配置url地址
        }
        return $return_url;
    }

    /**
     * 移除 URLs 变量
     *
     * @param unknown $vars            
     */
    protected function unset_url_val(& $vars)
    {
        unset($vars[RC_Config::get('route.module')]);
        unset($vars[RC_Config::get('route.controller')]);
        unset($vars[RC_Config::get('route.action')]);
        unset($vars[RC_Config::get('route.lang')]);
        unset($vars[RC_Config::get('route.page')]);
        unset($vars[RC_Config::get('route.route')]);
    }



    /**
     * SQL的limit语句
     *
     * @param bool $stat
     *            true 返回字符串 false 返回数组
     * @return array string
     */
    public function limit($stat = false)
    {
        if ($stat) {
            return max(0, ($this->current_page - 1) * $this->page_size) . "," . $this->page_size;
        } else {
            return array(
                "limit" => max(0, ($this->current_page - 1) * $this->page_size) . "," . $this->page_size
            );
        }
    }

    /**
     * 返回所有分页信息
     *
     * @return Array
     */
    public function get_all()
    {
        $show = array();
        $show['count'] = $this->count();
        $show['first'] = $this->first();
        $show['pre'] = $this->pre();
        $show['pres'] = $this->pres();
        $show['text_list'] = $this->text_list();
        $show['nexts'] = $this->nexts();
        $show['next'] = $this->next();
        $show['end'] = $this->end();
        $show['now_page'] = $this->now_page();
        $show['select'] = $this->select();
        $show['input'] = $this->input();
        $show['pic_list'] = $this->pic_list();
        return $show;
    }

    /**
     * 显示页码
     *
     * @param string $style
     *            风格
     * @param int $page_row
     *            页码显示行数
     * @return string
     */
    public function show($style = '', $page_row = null)
    {
        if (empty($style)) {
            $style = RC_Config::get('system.page_style');
        }
        // 页码显示行数
        $this->page_row = is_null($page_row) ? $this->page_row : $page_row - 1;
        switch ($style) {
            case 1:
                return $this->count() . $this->first() . $this->pre() . $this->pres() . $this->text_list() . $this->nexts() . $this->next() . $this->end() . $this->now_page() . $this->select() . $this->input() . $this->pic_list();
            case 2:
                return $this->pre() . $this->text_list() . $this->next() . $this->count();
            case 3:
                return $this->pre() . $this->text_list() . $this->next();
            case 5:
                return $this->first() . $this->pre() . $this->text_list() . $this->next() . $this->end();
            default:
                return $this->pre() . $this->text_list() . $this->next() . $this->count();
        }
    }

}

// end