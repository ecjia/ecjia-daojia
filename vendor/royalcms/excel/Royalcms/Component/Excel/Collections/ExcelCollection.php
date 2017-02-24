<?php namespace Royalcms\Component\Excel\Collections;

use Royalcms\Component\Support\Collection;

/**
 *
 * Royalcms Excel ExcelCollection
 *
 */
class ExcelCollection extends Collection {

    /**
     * Sheet title
     * @var [type]
     */
    protected $title;

    /**
     * Get the title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the title
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}