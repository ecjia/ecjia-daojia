<?php

namespace Royalcms\Component\DirectoryHasher\Writer\File;

interface FileInterface
{
    /**
     * Write a Result to file
     *
     * @param  \Royalcms\Component\DirectoryHasher\Result $result
     * @param  string $file
     *
     * @throws \Royalcms\Component\DirectoryHasher\Exception
     */
    public function write(\Royalcms\Component\DirectoryHasher\Result $result, $file);
}
