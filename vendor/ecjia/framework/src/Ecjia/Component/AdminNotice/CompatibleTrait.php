<?php


namespace Ecjia\Component\AdminNotice;


trait CompatibleTrait
{

    /**
     * @deprecated 2.7.0
     * @see AdminNotice::getContent()
     * @return string
     */
    public function get_content()
    {
        return $this->content;
    }

    /**
     * @deprecated 2.7.0
     * @see AdminNotice::getType()
     * @return string
     */
    public function get_type()
    {
        return $this->type;
    }

    /**
     * @deprecated 2.7.0
     * @see AdminNotice::isAllowClose()
     * @return bool
     */
    public function get_allow_close()
    {
        return $this->allow_close;
    }

}