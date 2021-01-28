<?php


namespace Royalcms\Component\App\Contracts;


interface ApplicationStorageInterface
{

    /**
     * Read data.
     */
    public function read();


    /**
     * Write data.
     */
    public function write();


    /**
     * Remove data.
     */
    public function remove();

}