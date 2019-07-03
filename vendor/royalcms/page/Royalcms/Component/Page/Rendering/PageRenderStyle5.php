<?php


namespace Royalcms\Component\Page\Rendering;


class PageRenderStyle5 extends DefaultPageRender
{

    /**
     * @return string
     */
    public function toHtml()
    {
        return $this->first() . $this->prev() . $this->pageList() . $this->next() . $this->last();
    }

}