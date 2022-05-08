<?php


namespace Ecjia\Component\AdminNavHere;


trait CompatibleTrait
{

    /**
     * @deprecated 2.7.0
     * @see AdminNavHere::getLabel()
     * @return string
     */
    public function get_label()
    {
        return $this->label;
    }

    /**
     * @deprecated 2.7.0
     * @see AdminNavHere::getLink()
     * @return string
     */
    public function get_link()
    {
        return $this->link;
    }

}