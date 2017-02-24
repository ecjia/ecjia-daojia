<?php namespace Royalcms\Component\Excel\Parsers;

use Royalcms\Component\Excel\Readers\HtmlReader;
use Royalcms\Component\Support\Facades\View;

/**
 *
 * Royalcms Excel ViewParser
 *
 */
class ViewParser {

    /**
     * View file
     * @var string
     */
    public $view;

    /**
     * Data array
     * @var array
     */
    public $data = array();

    /**
     * View merge data
     * @var array
     */
    public $mergeData = array();

    /**
     * Construct the view parser
     * @param Html $reader
     * @return \Royalcms\Component\Excel\Parsers\ViewParser
     */
    public function __construct(HtmlReader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Parse the view
     * @param  \Royalcms\Component\Excel\Classes\ExcelWorksheet $sheet
     * @return \Royalcms\Component\Excel\Classes\ExcelWorksheet
     */
    public function parse($sheet)
    {
        $html = View::make($this->getView(), $this->getData(), $this->getMergeData())->render();

        return $this->_loadHTML($sheet, $html);
    }

    /**
     * Load the HTML
     * @param  \Royalcms\Component\Excel\Classes\ExcelWorksheet $sheet
     * @param  string                                           $html
     * @return \Royalcms\Component\Excel\Classes\ExcelWorksheet
     */
    protected function _loadHTML($sheet, $html)
    {
        return $this->reader->load($html, true, $sheet);
    }

    /**
     * Get the view
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Get data
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get merge data
     * @return array
     */
    public function getMergeData()
    {
        return $this->mergeData;
    }

    /**
     * Set the view
     * @param bool|string $view
     */
    public function setView($view = false)
    {
        if ($view)
            $this->view = $view;
    }

    /**
     * Set the data
     * @param array $data
     */
    public function setData($data = array())
    {
        if (!empty($data))
            $this->data = array_merge($this->data, $data);
    }

    /**
     * Set the merge data
     * @param array $mergeData
     */
    public function setMergeData($mergeData = array())
    {
        if (!empty($mergeData))
            $this->mergeData = array_merge($this->mergeData, $mergeData);
    }
}