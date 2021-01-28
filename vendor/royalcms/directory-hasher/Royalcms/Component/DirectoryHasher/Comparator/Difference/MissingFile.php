<?php

namespace Royalcms\Component\DirectoryHasher\Comparator\Difference;

/**
 * Difference if a file is missing
 */
class MissingFile implements DifferenceInterface
{

    /**
     * @var string
     */
    protected $file;

    /**
     * @param string $file
     */
    public function __construct($file) {
        $this->file = $file;
    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * {@inheritDoc}
     */
    public function toString() {
        return 'Result is missing file "' . $this->file . '"';
    }

}
