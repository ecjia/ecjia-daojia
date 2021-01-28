<?php

namespace Royalcms\Component\DirectoryHasher\Hasher;

use Royalcms\Component\DirectoryHasher\Result\File;
use Royalcms\Component\DirectoryHasher\Result;

/**
 * Abstract Implementation for Hasher
 */
abstract class HasherAbstract implements HasherInterface
{

    /**
     * {@inheritdoc}
     */
    public function addHashsToFileResult(File $file) {

        $hashs = $this->getHashsForFile($file->getFilename());
        foreach ($hashs as $name => $value) {
            $file->addHash($name, $value);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addHashsToResult(Result $result) {

        foreach ($result as $file) {
            $this->addHashsToFileResult($file);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getHashsForFile($file);
}
