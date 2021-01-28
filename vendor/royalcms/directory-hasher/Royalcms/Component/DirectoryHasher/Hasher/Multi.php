<?php

namespace Royalcms\Component\DirectoryHasher\Hasher;

use Royalcms\Component\DirectoryHasher\Result\File;
use Royalcms\Component\DirectoryHasher\Result;

/**
 * Runs multiple hashers
 */
class Multi implements HasherInterface
{

    /**
     *
     * @var array|\Royalcms\Component\DirectoryHasher\Hasher\HasherInterface[]
     */
    protected $hasher = array();

    /**
     * @param array|\Royalcms\Component\DirectoryHasher\Hasher\HasherInterface[] $hasher
     */
    public function __construct(array $hasher) {
        $this->hasher = $hasher;
    }

    /**
     * {@inheritdoc}
     */
    public function addHashsToFileResult(File $file) {
        foreach ($this->hasher as $hasher) {
            /* @var $hasher \Royalcms\Component\DirectoryHasher\Hasher\HasherInterface */
            $hasher->addHashsToFileResult($file);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addHashsToResult(Result $result) {
        foreach ($this->hasher as $hasher) {
            /* @var $hasher \Royalcms\Component\DirectoryHasher\Hasher\HasherInterface */
            $hasher->addHashsToResult($result);
        }

        return $this;
    }

}
