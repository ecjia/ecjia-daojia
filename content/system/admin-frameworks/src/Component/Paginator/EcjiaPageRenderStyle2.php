<?php


namespace Ecjia\System\Frameworks\Component\Paginator;


use Royalcms\Component\Page\Rendering\DefaultPageRender;

class EcjiaPageRenderStyle2 extends DefaultPageRender
{
    /**
     * 上一页
     *
     * @return string
     */
    public function prev()
    {
        if ($this->paginator->getPrevUrl()) {
            $html = '<li><a class="a1 data-pjax external_link" href="' . htmlspecialchars($this->paginator->getPrevUrl()) . '">&laquo; '. $this->paginator->getPreviousText() .'</a></li>';
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
            $html = '<li><a class="a1 data-pjax external_link" href="' . htmlspecialchars($this->paginator->getNextUrl()) . '">'. $this->paginator->getNextText() .' &raquo;</a></li>';
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

        $html = '<li><a class="first a1 data-pjax external_link" href="' . htmlspecialchars($page['url']) . '">'. $this->paginator->getFirstText() .'</a></li>';

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

        $html = '<li><a class="end a1 data-pjax external_link" href="' . htmlspecialchars($page['url']) . '">'. $this->paginator->getLastText() .'</a></li>';

        return $html;
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
                $html .= '<li' . ($page['isCurrent'] ? ' class="active"' : '') . '><a class="a1 data-pjax external_link" href="' . htmlspecialchars($page['url']) . '">' . htmlspecialchars($page['num']) . '</a></li>';
            } else {
                $html .= '<li class="disabled"><span>' . htmlspecialchars($page['num']) . '</span></li>';
            }
        }

        return $html;
    }

    /**
     * count统计
     *
     * @return string
     */
    public function count()
    {
        $lang = array(
            'total_records' => __('总计 '),
            'total_pages' 	=> __('条记录，分为'),
            'page_current' 	=> __('页当前第'),
            'page_size' 	=> __('页，每页'),
            'page'			=> __(' 页'),
        );

        return <<< EOF
  		{$lang['total_records']} <span id="totalRecords">{$this->paginator->getTotalItems()}</span>
 		{$lang['total_pages']} <span id="totalPages">{$this->paginator->getNumPages()}{$lang['page']}</span>
EOF;

    }

    /**
     * @return string
     */
    public function toHtml()
    {
        $desc = $this->count();
        $page = $this->first() . $this->prev() . $this->pageList() . $this->next() . $this->last();

        return <<<EOF
	    	<div class="page pagination">
				<div class="pull-left">
					{$desc}
				</div>
				<div class="pull-right">
				    <ul>
	    			{$page}
	    			</ul>
				</div>
			</div>
EOF;
    }


}