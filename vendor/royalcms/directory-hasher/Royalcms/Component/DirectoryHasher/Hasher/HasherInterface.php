<?php

namespace Royalcms\Component\DirectoryHasher\Hasher;

use Royalcms\Component\DirectoryHasher\Result\File;
use Royalcms\Component\DirectoryHasher\Result;

/**
 * Hasher Interface
 */
interface HasherInterface
{
    /**
     * Adds the hashes to the file result
     *
     * @param \Royalcms\Component\DirectoryHasher\Result\File $file
     * @return \Royalcms\Component\DirectoryHasher\Hasher\HasherInterface *Provides fluent interface*
     */
    public function addHashsToFileResult(File $file);

    /**
     * Adds the hashes to the result
     *
     * @param \Royalcms\Component\DirectoryHasher\Result $result
     * @return \Royalcms\Component\DirectoryHasher\Hasher\HasherInterface *Provides fluent interface*
     */
    public function addHashsToResult(Result $result);
}
