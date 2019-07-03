<?php

namespace Royalcms\Component\Page;

use Royalcms\Component\Page\Contracts\Presenter;
use RC_Uri;
use RC_Config;
use Royalcms\Component\Page\Rendering\PageRenderStyle1;
use Royalcms\Component\Page\Rendering\PageRenderStyle2;
use Royalcms\Component\Page\Rendering\PageRenderStyle3;
use Royalcms\Component\Page\Rendering\PageRenderStyle4;
use Royalcms\Component\Page\Rendering\PageRenderStyle5;

/**
 * 分页处理类
 *
 * @package Core
 */
abstract class Page implements Presenter
{

//    protected static $static_total_pages = null; // 总页数
    protected static $static_url = null; // 当前url
    protected static $fix = ''; // 静态后缀如.html

    protected static $page_num_label; // 替换标签 {page}


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

    protected $paginator;
    
    /**
     *
     * @param int $total
     *            总条数
     * @param string $row
     *            每页显示条数
     * @param string $page_row
     *            显示页码数量
     * @param array|null $desc
     *            描述文字
     * @param int $set_current_page
     *            当前页
     * @param string $custom_url
     *            自定义url地址
     * @param string $page_num_label
     *            页码变量,默认为{page}
     */
    function __construct($total, $row = '', $page_row = '', $desc = null, $set_current_page = null, $custom_url = '', $page_num_label = '')
    {
        self::$page_num_label = Paginator::NUM_PLACEHOLDER; // 替换标签

        $this->setUrl($custom_url);
        $this->setCurrentPage($set_current_page);
        $this->setPageSize($row);
        $this->setPagesToShow($page_row);
        $this->setDescriptionLabels($desc);


        $this->paginator = new Paginator($total, $this->getPageSize(), $this->getCurrentPage(), $this->getUrl());
        $this->paginator->setNextText($this->desc['next']);
        $this->paginator->setPreviousText($this->desc['prev']);
        $this->paginator->setFirstText($this->desc['first']);
        $this->paginator->setLastText($this->desc['last']);
        $this->paginator->setMaxPagesToShow($this->getPageToShow());


        //兼容处理
        $this->total_records = $this->paginator->getTotalItems(); // 总条数
        $this->total_pages = $this->paginator->getNumPages(); // 总页数
        $this->start_id = $this->paginator->getCurrentPageFirstItem(); // 当前页开始ID
        $this->end_id = $this->paginator->getCurrentPageLastItem(); // 当前页结束ID



//        $this->page_size = empty($row) ? RC_Config::get('system.page_show_row') : $row; // 每页显示条数
//        $this->page_row = (empty($page_row) ? RC_Config::get('system.page_row') : $page_row) - 1; // 显示页码数量
//        $this->total_pages = ceil($this->total_records / $this->page_size); // 总页数
//        self::$static_total_pages = $this->total_pages; // 总页数
//        self::$page_num_label = empty($page_num_label) ? self::$page_num_label : $page_num_label; // 替换标签



//        $set_current_page = empty($set_current_page) ? $page_var : max(1, intval($set_current_page));


//        $this->start_id = ($this->current_page - 1) * $this->page_size + 1; // 当前页开始ID
//        $this->end_id = min($this->current_page * $this->page_size, $this->total_records); // 当前页结束ID
//        $this->desc =

//        $this->request = royalcms('request');



//        dd($this->paginator->getPages());
        // 配置url地址
//        $this->setUrl($custom_url);
    }

    /**
     * 配置描述文字
     * @param array|null $desc
     *            <code>
     *            "prev"	=>	"上一页"
     *            "next"	=>	"下一页"
     *            "prevs"	=>	"前十页"
     *            "nexts"	=>	"下十页"
     *            "first"	=>	"首页"
     *            "last"	=>	"尾页"
     *            "unit"	=>	"条"
     *            </code>
     * @return $this
     */
    public function setDescriptionLabels($desc)
    {
        $this->desc = array_change_key_case(config('system.page_desc'));

        array_walk_recursive($this->desc, array($this, 'call_desc_gettext'));

        if (empty($desc) || ! is_array($desc)) {
            return $this;
        }

        $desc = array_filter($desc, array($this, 'call_desc_filter'));

        $this->desc = array_merge($this->desc, $desc);

        return $this;
    }


    public function call_desc_filter($item)
    {
        return ! empty($item);
    }

    public function call_desc_gettext(& $item, $key)
    {
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
    protected function removeRouteQuerys(& $querys)
    {
        array_forget($querys, config('route.module'));
        array_forget($querys, config('route.controller'));
        array_forget($querys, config('route.action'));
        array_forget($querys, config('route.page'));
        array_forget($querys, config('route.lang'));
        array_forget($querys, config('route.route'));

        $new_vars = [];

        foreach ($querys as $key => $var) {
            if (function_exists('remove_xss')) {
                $key = remove_xss($key);
                $var = remove_xss($var);
            } else {
                $key = simple_remove_xss($key);
                $var = simple_remove_xss($var);
            }

            $new_vars[$key] = $var;
        }

        $querys = $new_vars;
    }

    /**
     * 显示页码数量
     * @param $page_row
     */
    public function setPagesToShow($page_row)
    {
        if (empty($page_row)) {
            $page_row = config('system.page_row');
        }

        if ($page_row < 3) {
            $page_row = 3;
        }

        $this->page_row = $page_row;

        return $this;
    }

    /**
     * @return int|string
     */
    public function getPageToShow()
    {
        return $this->page_row;
    }

    /**
     * 每页显示条数
     * @param $page_size
     */
    public function setPageSize($page_size)
    {
        if (empty($page_size)) {
            $page_size = config('system.page_show_row');
        }

        $this->page_size = $page_size;

        return $this;
    }

    /**
     * @return string
     */
    public function getPageSize()
    {
        return $this->page_size;
    }

    /**
     * 设置当前页码
     * @param $set_current_page
     * @return $this
     */
    public function setCurrentPage($set_current_page)
    {
        if (empty($set_current_page)) {
            $page_var = intval($_GET[config('system.page_var')]);

            $page_var = empty($page_var) ? 1 : max(1, $page_var);

            $set_current_page = $page_var;
        }
        else {
            $set_current_page = max(1, intval($set_current_page));
        }

        $this->current_page = $set_current_page; // 当前页

        return $this;
    }

    /**
     * 获取当前页码
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->current_page;
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
            $gets = $_GET;
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
     * @param string $custom_url
     * @return string
     */
    protected function set_url($custom_url)
    {
        if (! empty($custom_url)) {
            $return_url = $custom_url;
        } elseif (is_null(self::$static_url)) {
            $get = $_GET;
            $this->unset_url_val($get);
            $url_type = config('system.url_mode');
            switch ($url_type) {
                case 'pathinfo':
                    $url = '/';
                    foreach ($get as $k => $v) {
                        $url .= $k . '/' . $v . '/';
                    }
                    $url = rtrim($url, '/') . '/' . config('system.page_var') . '/' . self::$page_num_label . self::$fix;
                    $return_url = RC_Uri::url(ROUTE_M . '/' . ROUTE_C . '/' . ROUTE_A . $url);
                    break;
                case 'normal':
                default:
                    $url = '';
                    foreach ($get as $k => $v) {
                        $url .= $k . "=" . $v . '&';
                    }
                    $url .= config('system.page_var') . '=' . self::$page_num_label;
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
     * @param array $vars
     */
    protected function unset_url_val(& $vars)
    {
        unset($vars[config('route.module')]);
        unset($vars[config('route.controller')]);
        unset($vars[config('route.action')]);
        unset($vars[config('route.lang')]);
        unset($vars[config('route.page')]);
        unset($vars[config('route.route')]);

        $new_vars = [];

        foreach ($vars as $key => $var) {
            if (function_exists('remove_xss')) {
                $key = remove_xss($key);
                $var = remove_xss($var);
            } else {
                $key = simple_remove_xss($key);
                $var = simple_remove_xss($var);
            }

            $new_vars[$key] = $var;
        }

        $vars = $new_vars;
    }



    /**
     * SQL的limit语句
     *
     * @param bool $stat
     *            true 返回字符串 false 返回数组
     * @return array|int
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
     * @return array
     */
    public function get_all()
    {
        $show = array(
            'count'         => $this->count(),
            'first'         => $this->first(),
            'pre'           => $this->pre(),
            'pres'          => $this->pres(),
            'text_list'     => $this->text_list(),
            'nexts'         => $this->nexts(),
            'next'          => $this->next(),
            'end'           => $this->end(),
            'now_page'      => $this->now_page(),
            'select'        => $this->select(),
            'input'         => $this->input(),
            'pic_list'      => $this->pic_list(),
        );

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
            $style = config('system.page_style');
        }
        // 页码显示行数
        $this->page_row = is_null($page_row) ? $this->page_row : $page_row - 1;
        switch ($style) {
            case 1:
//                return new PageRenderStyle1($this->paginator);
                return $this->count() . $this->first() . $this->pre() . $this->pres() . $this->text_list() . $this->nexts() . $this->next() . $this->end() . $this->now_page() . $this->select() . $this->input() . $this->pic_list();
            case 2:
//                return new PageRenderStyle2($this->paginator);
                return $this->pre() . $this->text_list() . $this->next() . $this->count();
            case 3:
//                return new PageRenderStyle3($this->paginator);
                return $this->pre() . $this->text_list() . $this->next();
            case 5:
//                return new PageRenderStyle5($this->paginator);
                return $this->first() . $this->pre() . $this->text_list() . $this->next() . $this->end();
            default:
//                return new PageRenderStyle2($this->paginator);
                return $this->pre() . $this->text_list() . $this->next() . $this->count();
        }
    }

}

// end