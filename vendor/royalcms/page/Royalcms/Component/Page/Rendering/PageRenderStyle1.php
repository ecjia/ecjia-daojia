<?php


namespace Royalcms\Component\Page\Rendering;


class PageRenderStyle1 extends DefaultPageRender
{

    /**
     * @return string
     */
    public function toHtml()
    {
        return $this->count() . $this->first() . $this->prev() . $this->pageList() . $this->next() . $this->last();
    }

}