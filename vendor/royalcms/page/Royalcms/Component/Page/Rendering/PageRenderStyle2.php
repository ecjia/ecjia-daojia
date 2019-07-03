<?php


namespace Royalcms\Component\Page\Rendering;


class PageRenderStyle2 extends DefaultPageRender
{

    /**
     * @return string
     */
    public function toHtml()
    {
        return $this->prev() . $this->pageList() . $this->next() . $this->count();
    }

}