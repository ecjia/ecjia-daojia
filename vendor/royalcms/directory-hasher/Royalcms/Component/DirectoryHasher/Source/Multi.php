<?php

namespace Royalcms\Component\DirectoryHasher\Source;

use Royalcms\Component\DirectoryHasher\Result;

class Multi implements SourceInterface
{

    /**
     * If the sources are already loaded
     *
     * @var boolean
     */
    protected $loaded = false;

    /**
     * @var \Royalcms\Component\DirectoryHasher\Result
     */
    protected $result;

    /**
     * @var array|\Royalcms\Component\DirectoryHasher\Source\SourceInterface[]
     */
    protected $sources;

    /**
     * @param array|\Royalcms\Component\DirectoryHasher\Source\SourceInterface[] $sources
     * @param \Royalcms\Component\DirectoryHasher\Result $result
     */
    public function __construct(array $sources, Result $result = null) {
        $this->sources = $sources;
        if ($result === null) {
            $result = new Result();
        }
        $this->result = $result;
    }

    /**
     * Fetches fileresults from all sources
     */
    protected function loadSources() {
        if ($this->loaded === true) {
            return;
        }
        foreach ($this->sources as $source) {
            /* @var $source \Royalcms\Component\DirectoryHasher\Source\SourceInterface */
            $this->result->addFileResults(
                    $source->getFileResults()
            );
        }
        $this->loaded = true;
    }

    /**
     * {@inheritdoc}
     */
    public function getFileResults() {
        $this->loadSources();

        return $this->result->getIterator()->getArrayCopy();
    }

    /**
     * @return \Royalcms\Component\DirectoryHasher\Result
     */
    public function getResult()
    {
        return $this->result;
    }

}
