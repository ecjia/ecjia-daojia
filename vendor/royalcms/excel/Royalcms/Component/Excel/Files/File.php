<?php namespace Royalcms\Component\Excel\Files;

use Royalcms\Component\Foundation\Royalcms;
use Royalcms\Component\Excel\Excel;
use Royalcms\Component\Excel\Exceptions\ExcelException;

abstract class File {

    /**
     * @var Royalcms
     */
    protected $royalcms;

    /**
     * Excel instance
     * @var Excel
     */
    protected $excel;

    /**
     * Loaded file
     * @var \Royalcms\Component\Excel\Readers\ExcelReader
     */
    protected $file;


    /**
     * @param Application $app
     * @param Excel       $excel
     */
    public function __construct(Royalcms $royalcms, Excel $excel)
    {
        $this->royalcms = $royalcms;
        $this->excel = $excel;
    }

    /**
     * Handle the import/export of the file
     * @param $type
     * @throws ExcelException
     * @return mixed
     */
    public function handle($type)
    {
        // Get the handler
        $handler = $this->getHandler($type);

        // Call the handle method and inject the file
        return $handler->handle($this);
    }

    /**
     * Get handler
     * @param $type
     * @throws ExcelException
     * @return mixed
     */
    protected function getHandler($type)
    {
        return $this->royalcms->make(
            $this->getHandlerClassName($type)
        );
    }

    /**
     * Get the file instance
     * @return mixed
     */
    public function getFileInstance()
    {
        return $this->file;
    }

    /**
     * Get the handler class name
     * @throws ExcelException
     * @return string
     */
    protected function getHandlerClassName($type)
    {
        // Translate the file into a FileHandler
        $class = get_class($this);
        $handler = substr_replace($class, $type . 'Handler', strrpos($class, $type));

        // Check if the handler exists
        if (!class_exists($handler))
            throw new ExcelException("$type handler [$handler] does not exist.");

        return $handler;
    }
}