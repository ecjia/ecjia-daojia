<?php


namespace Royalcms\Component\Page\Rendering;


class PageRenderStyle4 extends DefaultPageRender
{

    /**
     * count统计
     *
     * @return string
     */
    public function count()
    {
        $totalItemsLabel = sprintf("总计:%s条", $this->paginator->getTotalItems());
        return "<span class='total'>{$totalItemsLabel}</span>";
    }

    /**
     * 上一页
     *
     * @return string
     */
    public function prev()
    {
        if ($this->paginator->getPrevUrl()) {
            $html = '<li><a href="' . htmlspecialchars($this->paginator->getPrevUrl()) . '"><span> &laquo;&laquo; </span></a></li>';
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
            $html = '<li><a href="' . htmlspecialchars($this->paginator->getNextUrl()) . '"><span> &raquo;&raquo; </span></a></li>';
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
        if ($this->paginator->getCurrentPage() == 1) {
            return '';
        }

        $pages = $this->paginator->getPages();

        $page = head($pages);

        $html = '<li><a href="' . htmlspecialchars($page['url']) . '"><span> &laquo; </span></a></li>';

        return $html;
    }

    /**
     * 末页
     *
     * @return string
     */
    public function last()
    {
        if ($this->paginator->getCurrentPage() == $this->paginator->getNumPages()) {
            return '';
        }

        $pages = $this->paginator->getPages();

        $page = head($pages);

        $html = '<li><a href="' . htmlspecialchars($page['url']) . '"><span> &raquo; </span></a></li>';

        return $html;
    }

    /**
     * @return string
     */
    public function toHtml()
    {
        return $this->count() . $this->first() . $this->prev() . $this->next() . $this->last() . $this->select();
    }

}