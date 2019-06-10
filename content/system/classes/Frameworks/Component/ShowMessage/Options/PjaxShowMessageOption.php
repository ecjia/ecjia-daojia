<?php


namespace Ecjia\System\Frameworks\Component\ShowMessage\Options;


use Ecjia\System\Frameworks\Contracts\ShowMessageOptionInterface;

class PjaxShowMessageOption extends AjaxShowMessageOption implements ShowMessageOptionInterface
{

    /**
     * pjax请求后返回的跳转地址，可以为空，不跳转
     * @var string
     */
    protected $pjaxurl;

    /**
     * 返回执行后去向的链接，可以为空
     * @var array
     */
    protected $links;

    /**
     * @return string
     */
    public function getPjaxurl()
    {
        return $this->pjaxurl;
    }

    /**
     * @param string $pjaxurl
     * @return PjaxShowMessageOption
     */
    public function setPjaxurl($pjaxurl)
    {
        $this->pjaxurl = $pjaxurl;
        return $this;
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param array $links
     * @return PjaxShowMessageOption
     */
    public function setLinks($links)
    {
        $this->links = $links;
        return $this;
    }

    public function toArray()
    {
        $data = parent::toArray();

        if ($this->getPjaxurl()) {
            $data['pjaxurl'] = $this->getPjaxurl();
        }

        if ($this->getLinks()) {
            $data['links'] = $this->getLinks();
        }

        return $data;
    }

}