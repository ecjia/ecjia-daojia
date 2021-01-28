<?php

namespace Royalcms\Component\DirectoryHasher;

use Royalcms\Component\DirectoryHasher\Hasher\HasherInterface;
use Royalcms\Component\DirectoryHasher\Source\SourceInterface;
use Royalcms\Component\DirectoryHasher\Result;

class DirectoryHasher
{

    /**
     *
     * @var \Royalcms\Component\DirectoryHasher\Result
     */
    protected $result;

    /**
     *
     * @var \Royalcms\Component\DirectoryHasher\Hasher\HasherInterface
     */
    protected $hasher;

    /**
     * @var \Royalcms\Component\DirectoryHasher\Source\SourceInterface
     */
    protected $source;

    /**
     * @param \Royalcms\Component\DirectoryHasher\Source\SourceInterface $source
     * @param \Royalcms\Component\DirectoryHasher\Hasher\HasherInterface $hasher
     * @param \Royalcms\Component\DirectoryHasher\Result $result
     */
    public function __construct(SourceInterface $source,
                                HasherInterface $hasher,
                                Result $result = null) {
        $this->source = $source;
        $this->hasher = $hasher;
        if (null === $result) {
            $result = new Result();
        }
        $this->result = $result;
    }

    /**
     * Fetches files from source
     *
     * @return \Royalcms\Component\DirectoryHasher\Result
     */
    public function run() {
        $this->result->addFileResults($this->source->getFileResults());
        $this->hasher->addHashsToResult($this->result);

        return $this->result;
    }

    /**
     * Returns the Result
     *
     * @return \Royalcms\Component\DirectoryHasher\Result
     */
    public function getResult() {
        return $this->result;
    }

}
