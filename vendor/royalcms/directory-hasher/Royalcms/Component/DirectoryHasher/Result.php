<?php

namespace Royalcms\Component\DirectoryHasher;

use IteratorAggregate;
use Countable;
use ArrayIterator;
use \Royalcms\Component\DirectoryHasher\Result\File;

/**
 *
 */
class Result implements IteratorAggregate, Countable
{

    /**
     * @var array|\Royalcms\Component\DirectoryHasher\Result\File[]
     */
    protected $results;

    /**
     * @param array|\Royalcms\Component\DirectoryHasher\Result\File[] $results
     */
    public function __construct(array $results = array()) {
        $this->results = $results;
    }

    /**
     * Adds a FileResult
     *
     * @param \Royalcms\Component\DirectoryHasher\Result\File $fileResult
     * @return \Royalcms\Component\DirectoryHasher\Result *Provides fluent interface*
     */
    public function addFileResult(File $fileResult) {
        $this->results[] = $fileResult;

        return $this;
    }

    /**
     * Adds a FileResult
     *
     * @param \Royalcms\Component\DirectoryHasher\Result\File $fileResult
     * @return \Royalcms\Component\DirectoryHasher\Result *Provides fluent interface*
     */
    public function addFileResults(array $fileResults) {
        foreach ($fileResults as $fileResult) {
            /* @var $fileResult \Royalcms\Component\DirectoryHasher\Result\File */
            $this->addFileResult($fileResult);
        }

        return $this;
    }

    /**
     * Returns an ArrayIterator
     *
     * @return ArrayIterator
     */
    public function getIterator() {
        return new ArrayIterator($this->results);
    }

    /**
     * Checks if there is a FileResult for a specific filename
     *
     * @param string $filename
     * @return boolean
     */
    public function hasFileResultFor($filename) {
        foreach ($this->results as $result) {
            /* @var $result \Royalcms\Component\DirectoryHasher\Result\File */

            if ($filename === $result->getFilename()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns a FileResult for a specific filename
     *
     * @param string $filename
     * @return \Royalcms\Component\DirectoryHasher\Result\File|null
     */
    public function getFileResultFor($filename) {
        foreach ($this->results as $result) {
            /* @var $result \Royalcms\Component\DirectoryHasher\Result\File */
            if ($filename === $result->getFilename()) {
                return $result;
            }
        }

        return null;
    }

    /**
     * Implements SPL::Countable
     *
     * @return integer
     */
    public function count() {
        return count($this->results);
    }

}
