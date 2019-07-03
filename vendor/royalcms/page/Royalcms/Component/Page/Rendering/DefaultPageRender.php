<?php


namespace Royalcms\Component\Page\Rendering;


use Royalcms\Component\Page\Paginator;

class DefaultPageRender
{
    protected $paginator;

    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * 上一页
     *
     * @return string
     */
    public function prev()
    {
        if ($this->paginator->getPrevUrl()) {
            $html = '<li><a href="' . htmlspecialchars($this->paginator->getPrevUrl()) . '">&laquo; '. $this->paginator->getPreviousText() .'</a></li>';
        } else {
            $html = '';
        }

        return $html;
    }

    /**
     * 下一页
     *
     * @return string
     */
    public function next()
    {
        if ($this->paginator->getNextUrl()) {
            $html = '<li><a href="' . htmlspecialchars($this->paginator->getNextUrl()) . '">'. $this->paginator->getNextText() .' &raquo;</a></li>';
        } else {
            $html = '';
        }

        return $html;
    }

    /**
     * 首页
     *
     * @return string
     */
    public function first()
    {
        $pages = $this->paginator->getPages();

        $page = head($pages);

        $html = '<li><a href="' . htmlspecialchars($page['url']) . '">'. $this->paginator->getFirstText() .'</a></li>';

        return $html;
    }

    /**
     * 末页
     *
     * @return string
     */
    public function last()
    {
        $pages = $this->paginator->getPages();

        $page = last($pages);

        $html = '<li><a href="' . htmlspecialchars($page['url']) . '">'. $this->paginator->getLastText() .'</a></li>';

        return $html;
    }

    /**
     * count统计
     *
     * @return string
     */
    public function count()
    {
        $numPagesLabel = sprintf("[共%s页]", $this->paginator->getNumPages());
        $totalItemsLabel = sprintf("[%s条记录]", $this->paginator->getTotalItems());
        return "<span class='count'>{$numPagesLabel} {$totalItemsLabel}</span>";
    }

    /**
     * 输入框
     *
     * @return string
     */
    public function input()
    {
        $url = $this->paginator->getUrlPattern();
        /*
         * 数型返回url地址 b(before)返回url地址前部分 a(after)返回url地址后部分
         */
        $url_before = substr($url, 0, strpos($url, Paginator::NUM_PLACEHOLDER));
        $url_after = substr($url, strpos($url, Paginator::NUM_PLACEHOLDER) + strlen(Paginator::NUM_PLACEHOLDER));

        $str = "<input id='page_keydown' type='text' name='page' value='{$this->paginator->getCurrentPage()}' class='page_input' onkeydown = \"javascript:
					if (event.keyCode === 13) {
						location.href = '{$url_before}' + this.value + '{$url_after}';
					}
				\"/>
				<button class='page_button' onclick = \"javascript:
					var input = document.getElementById('page_keydown');
					location.href = '{$url_before}' + input.value + '{$url_after}';
				\">进入</button>
";
        return $str;
    }

    /**
     * 选项列表
     *
     * @return string
     */
    public function select()
    {
        $pages = $this->paginator->getPages();
        if (empty($pages)) {
            return '';
        }

        $html = '<select name="page" class="page_select" onchange="javascript:location.href = this.options[selectedIndex].value;">';

        foreach ($pages as $page) {
            if (!empty($page['url'])) {
                $html .= '<option value="' . htmlspecialchars($page['url']) . '">' . htmlspecialchars($page['num']) . '</option>';
            } else {
                $html .= '<option value="' . htmlspecialchars($page['url']) . ' selected="selected">' . htmlspecialchars($page['num']) . '</option>';
            }
        }

        return $html . "</select>";
    }

    /**
     * 文字页码列表
     *
     * @return string
     */
    public function pageList()
    {
        $pages = $this->paginator->getPages();

        $html = '';

        foreach ($pages as $page) {
            if ($page['url']) {
                $html .= '<li' . ($page['isCurrent'] ? ' class="active"' : '') . '><a href="' . htmlspecialchars($page['url']) . '">' . htmlspecialchars($page['num']) . '</a></li>';
            } else {
                $html .= '<li class="disabled"><span>' . htmlspecialchars($page['num']) . '</span></li>';
            }
        }

        return $html;
    }

    /**
     * @return string
     */
    public function toHtml()
    {

    }


    public function __toString()
    {
        return $this->toHtml();
    }


}