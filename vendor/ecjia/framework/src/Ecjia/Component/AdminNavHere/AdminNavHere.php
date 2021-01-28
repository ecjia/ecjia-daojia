<?php

namespace Ecjia\Component\AdminNavHere;

class AdminNavHere
{
    use CompatibleTrait;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $link;

    public function __construct($label, $link = null)
    {
        $this->label = $label;
        $this->link  = $link;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return AdminNavHere
     */
    public function setLabel(string $label): AdminNavHere
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return AdminNavHere
     */
    public function setLink(string $link): AdminNavHere
    {
        $this->link = $link;
        return $this;
    }



}