<?php

namespace Royalcms\Component\DirectoryHasher\Comparator\Difference;

/**
 * Difference if a hash is missing
 */
class MissingHash implements DifferenceInterface
{
    /**
     * @var string
     */
    protected $file;

    /**
     * @var string
     */
    protected $hashname;

    /**
     * @param string $file
     * @param string $hashname
     */
    public function __construct($file, $hashname)
    {
        $this->file = $file;
        $this->hashname = $hashname;
    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * {@inheritDoc}
     */
    public function toString() {
        return 'File "' . $this->file . '" misses "' . $this->hashname.'"';
    }
}
