<?php

namespace Royalcms\Component\Page;

use Royalcms\Component\Support\Facades\Config;

/**
 * 分页处理类
 *
 * @package Core
 */
class DefaultPage extends Page
{

    /**
     * 上一页
     *
     * @return string
     */
    public function pre()
    {
        if ($this->current_page > 1 && $this->current_page <= $this->total_pages) {
            return "<a href='" . $this->get_url($this->current_page - 1) . "' class='pre'>{$this->desc['pre']}</a>";
        }
        return "<span class='close'>{$this->desc['pre']}</span>";
    }

    /**
     * 下一页
     *
     * @return string
     */
    public function next()
    {
        $next = $this->desc['next'];
        if ($this->current_page < $this->total_pages) {
            return "<a href='" . $this->get_url($this->current_page + 1) . "' class='next'>{$next}</a>";
        }
        return "<span class='close'>{$next}</span>";
    }

    /**
     * 文字页码列表
     *
     * @return string
     */
    public function text_list()
    {
        $arr = $this->page_list();
        $str = "";
        if (empty($arr))
            return "<strong class='selfpage'>1</strong>";
        foreach ($arr as $v) {
            $str .= empty($v['url']) ? "<strong class='selfpage'>" . $v['str'] . "</strong>" : "<a href={$v['url']}>{$v['str']}</a>";
        }
        return $str;
    }

    /**
     * 图标页码列表
     *
     * @return string
     */
    public function pic_list()
    {
        $str = '';
        $first = $this->current_page == 1 ? "" : "<a href='" . $this->get_url(1) . "' class='pic_list'><span><<</span></a>";
        $end = $this->current_page >= $this->total_pages ? "" : "<a href='" . $this->get_url($this->total_pages) . "'  class='picList'><span>>></span></a>";
        $pre = $this->current_page <= 1 ? "" : "<a href='" . $this->get_url($this->current_page - 1) . "'  class='pic_list'><span><</span></a>";
        $next = $this->current_page >= $this->total_pages ? "" : "<a href='" . $this->get_url($this->current_page + 1) . "'  class='pic_list'><span>></span></a>";
        
        return $first . $pre . $next . $end;
    }

    /**
     * 选项列表
     *
     * @return string
     */
    public function select()
    {
        $arr = $this->page_list();
        if (! $arr) {
            return '';
        }
        $str = "<select name='page' class='page_select' onchange='
		javascript:
		location.href=this.options[selectedIndex].value;'>";
        foreach ($arr as $v) {
            $str .= empty($v['url']) ? "<option value='{$this->get_url($v['str'])}' selected='selected'>{$v['str']}</option>" : "<option value='{$v['url']}'>{$v['str']}</option>";
        }
        return $str . "</select>";
    }

    /**
     * 输入框
     *
     * @return string
     */
    public function input()
    {
        $str = "<input id='pagekeydown' type='text' name='page' value='{$this->current_page}' class='pageinput' onkeydown = \"javascript:
					if(event.keyCode==13){
						location.href='{$this->get_url('B')}'+this.value+'{$this->get_url('A')}';
					}
				\"/>
				<button class='pagebt' onclick = \"javascript:
					var input = document.getElementById('pagekeydown');
					location.href='{$this->get_url('B')}'+input.value+'{$this->get_url('A')}';
				\">进入</button>
";
        return $str;
    }

    /**
     * 前几页
     *
     * @return string
     */
    public function pres()
    {
        $num = max(1, $this->current_page - $this->page_row);
        return $this->current_page > $this->page_row ? "<a href='" . $this->get_url($num) . "' class='pres'>前{$this->page_row}页</a>" : "";
    }

    /**
     * 后几页
     *
     * @return string
     */
    public function nexts()
    {
        $num = min($this->total_pages, $this->current_page + $this->page_row);
        return $this->current_page + $this->page_row < $this->total_pages ? "<a href='" . $this->get_url($num) . "' class='nexts'>后{$this->page_row}页</a>" : "";
    }

    /**
     * 首页
     *
     * @return string
     */
    public function first()
    {
        $first = $this->desc['first'];
        return $this->current_page - $this->page_row > 1 ? "<a href='" . $this->get_url(1) . " class='first'>{$first}</a>" : "";
    }

    /**
     * 末页
     *
     * @return string
     */
    public function end()
    {
        $end = $this->desc['end'];
        return $this->current_page < $this->total_pages - $this->page_row ? "<a href='" . $this->get_url($this->total_pages) . "' class='end'>{$end}</a>" : "";
    }

    /**
     * 当前页记录
     *
     * @return string
     */
    public function now_page()
    {
        return "<span class='now_page'>第{$this->start_id}-{$this->end_id}{$this->desc['unit']}</span>";
    }

    /**
     * count统计
     *
     * @return string
     */
    public function count()
    {
        return "<span class='count'>[共{$this->total_pages}页] [{$this->total_records}条记录]</span>";
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
            $style = Config::get('system.page_style');
        }
        // 页码显示行数
        $this->page_row = is_null($page_row) ? $this->page_row : $page_row - 1;
        switch ($style) {
            case 1:
                return "{$this->count()}{$this->first()}{$this->pre()}{$this->pres()}{$this->text_list()}{$this->nexts()}{$this->next()}{$this->end()}
    			{$this->now_page()}{$this->select()}{$this->input()}{$this->pic_list()}";
            case 2:
                return $this->pre() . $this->text_list() . $this->next() . $this->count();
            case 3:
                return $this->pre() . $this->text_list() . $this->next();
            case 4:
                return "<span class='total'>总计:{$this->total_records}
    				{$this->desc['unit']}</span>" . $this->pic_list() . $this->select();
            case 5:
                return $this->first() . $this->pre() . $this->text_list() . $this->next() . $this->end();
        }
    }
}

// end