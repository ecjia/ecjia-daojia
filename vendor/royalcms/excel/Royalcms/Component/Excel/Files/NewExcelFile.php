<?php namespace Royalcms\Component\Excel\Files;

use Royalcms\Component\Foundation\Royalcms;
use Royalcms\Component\Excel\Excel;

abstract class NewExcelFile extends File {

    /**
     * @param Application $app
     * @param Excel       $excel
     */
    public function __construct(Royalcms $royalcms, Excel $excel)
    {
        parent::__construct($royalcms, $excel);
        $this->file = $this->createNewFile();
    }

    /**
     * Get file
     * @return string
     */
    abstract public function getFilename();

    /**
     * Start importing
     */
    public function handleExport()
    {
        return $this->handle('Export');
    }


    /**
     * Load the file
     * @return \Royalcms\Component\Excel\Readers\ExcelReader
     */
    public function createNewFile()
    {
        // Load the file
        $file = $this->excel->create(
            $this->getFilename()
        );

        return $file;
    }

    /**
     * Dynamically call methods
     * @param  string $method
     * @param  array  $params
     * @return mixed
     */
    public function __call($method, $params)
    {
        return call_user_func_array([$this->file, $method], $params);
    }

}