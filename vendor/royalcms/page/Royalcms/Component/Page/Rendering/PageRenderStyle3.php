<?php


namespace Royalcms\Component\Page\Rendering;


class PageRenderStyle3 extends DefaultPageRender
{

    /**
     * @return string
     */
    public function toHtml()
    {
        return $this->prev() . $this->pageList() . $this->next();
    }

}